<?php

namespace common\services;

use common\models\TelegramImportLog;
use RuntimeException;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;

class TelegramNewsImporter
{
    private const DEFAULT_MAX_DOWNLOAD_BYTES = 52428800; // 50 MB

    private string $botToken;
    private string $channelId;
    private int $categoryId;
    private int $maxDownloadBytes;
    /** @var class-string<\yii\db\ActiveRecord> */
    private string $postModelClass;

    public function __construct()
    {
        $this->botToken = trim((string)(Yii::$app->params['telegramBotToken'] ?? getenv('TELEGRAM_BOT_TOKEN') ?: ''));
        $this->channelId = trim((string)(Yii::$app->params['telegramChannelId'] ?? getenv('TELEGRAM_CHANNEL_ID') ?: ''));
        $this->categoryId = (int)(Yii::$app->params['telegramNewsCategoryId'] ?? getenv('TELEGRAM_NEWS_CATEGORY_ID') ?: 1);
        $this->postModelClass = (string)(Yii::$app->params['telegramPostModelClass'] ?? getenv('TELEGRAM_POST_MODEL_CLASS') ?: 'backend\\models\\Post');
        $this->maxDownloadBytes = (int)(Yii::$app->params['telegramMaxDownloadBytes'] ?? getenv('TELEGRAM_MAX_MEDIA_BYTES') ?: self::DEFAULT_MAX_DOWNLOAD_BYTES);
        if ($this->maxDownloadBytes <= 0) {
            $this->maxDownloadBytes = self::DEFAULT_MAX_DOWNLOAD_BYTES;
        }

        if ($this->botToken === '') {
            throw new RuntimeException('TELEGRAM_BOT_TOKEN sozlanmagan');
        }
        if ($this->channelId === '') {
            throw new RuntimeException('TELEGRAM_CHANNEL_ID sozlanmagan');
        }
    }

    /**
     * @param array<string,mixed> $update
     * @return array{status:string,post_id?:int,reason?:string}
     */
    public function handleUpdate(array $update): array
    {
        $isEdit = isset($update['edited_channel_post']) && is_array($update['edited_channel_post']);
        $message = $update['channel_post'] ?? $update['edited_channel_post'] ?? null;

        if (!is_array($message)) {
            return ['status' => 'ignored', 'reason' => 'not_a_channel_post'];
        }

        $this->assertAllowedChannel($message);

        $chatId = (int)($message['chat']['id'] ?? 0);
        $messageId = (int)($message['message_id'] ?? 0);
        if ($chatId === 0 || $messageId === 0) {
            return ['status' => 'ignored', 'reason' => 'missing_ids'];
        }

        $existing = TelegramImportLog::findByMessage($chatId, $messageId);

        if ($isEdit) {
            if ($existing !== null && $existing->post_id) {
                $this->updateNewsPost((int)$existing->post_id, $message);
                TelegramImportLog::remember($chatId, $messageId, (int)$existing->post_id);
                return ['status' => 'updated', 'post_id' => (int)$existing->post_id];
            }

            $postId = $this->createNewsPost($message);
            TelegramImportLog::remember($chatId, $messageId, $postId);
            return ['status' => 'created', 'post_id' => $postId];
        }

        if ($existing !== null && $existing->post_id) {
            return ['status' => 'duplicate', 'post_id' => (int)$existing->post_id];
        }

        if ($existing !== null && !$existing->post_id) {
            $existing->delete();
        }

        return [
            'status' => 'created',
            'post_id' => $this->createNewsPostWithClaim($chatId, $messageId, $message),
        ];
    }

    /** @param array<string,mixed> $message */
    private function createNewsPostWithClaim(int $chatId, int $messageId, array $message): int
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!TelegramImportLog::claimMessage($chatId, $messageId)) {
                $claimed = TelegramImportLog::findByMessage($chatId, $messageId);
                if ($claimed !== null && $claimed->post_id) {
                    throw new RuntimeException('duplicate_message');
                }

                throw new RuntimeException('Telegram post band qilinmadi');
            }

            $postId = $this->createNewsPost($message);
            TelegramImportLog::remember($chatId, $messageId, $postId);
            $transaction->commit();

            return $postId;
        } catch (\Throwable $e) {
            if ($transaction->getIsActive()) {
                $transaction->rollBack();
            }
            throw $e;
        }
    }

    /** @param array<string,mixed> $message */
    private function assertAllowedChannel(array $message): void
    {
        $chat = $message['chat'] ?? [];
        if (($chat['type'] ?? '') !== 'channel') {
            throw new ForbiddenHttpException('Faqat kanal postlari qabul qilinadi');
        }

        if ((string)($chat['id'] ?? '') !== $this->channelId) {
            throw new ForbiddenHttpException('Ruxsat etilmagan kanal');
        }
    }

    /** @param array<string,mixed> $message */
    private function createNewsPost(array $message): int
    {
        $payload = $this->buildPostPayload($message);
        $modelClass = $this->postModelClass;
        if (!class_exists($modelClass)) {
            throw new RuntimeException('Post model topilmadi: ' . $modelClass);
        }

        /** @var \yii\db\ActiveRecord $model */
        $model = new $modelClass();
        $this->applyAttributes($model, $payload, true);

        if (!$model->save(false)) {
            throw new RuntimeException('Yangilik saqlanmadi');
        }

        return (int)$model->getPrimaryKey();
    }

    /** @param array<string,mixed> $message */
    private function updateNewsPost(int $postId, array $message): void
    {
        $modelClass = $this->postModelClass;
        /** @var \yii\db\ActiveRecord|null $model */
        $model = $modelClass::findOne($postId);
        if ($model === null) {
            throw new RuntimeException('Yangilik topilmadi: ' . $postId);
        }

        $payload = $this->buildPostPayload($message);
        $this->applyAttributes($model, $payload, false);

        if (!$model->save(false)) {
            throw new RuntimeException('Yangilik yangilanmadi');
        }
    }

    /**
     * @param array<string,mixed> $message
     * @return array<string,mixed>
     */
    private function buildPostPayload(array $message): array
    {
        $text = trim((string)($message['text'] ?? $message['caption'] ?? ''));
        $title = $this->buildTitle($text);
        $publishedAt = date('Y-m-d H:i:s', (int)($message['date'] ?? time()));

        $imagePath = null;
        $filePath = null;
        $extraHtml = '';

        try {
            if (!empty($message['photo']) && is_array($message['photo'])) {
                $largest = end($message['photo']);
                if (is_array($largest) && !empty($largest['file_id'])) {
                    $imagePath = $this->downloadTelegramFile((string)$largest['file_id'], 'jpg', 'img');
                }
            }

            if (!empty($message['video']) && is_array($message['video'])) {
                $filePath = $this->downloadTelegramFile((string)$message['video']['file_id'], 'mp4', 'file');
                $extraHtml .= $this->mediaHtml($filePath, 'video');
                if ($imagePath === null && !empty($message['video']['thumb']['file_id'])) {
                    $imagePath = $this->downloadTelegramFile((string)$message['video']['thumb']['file_id'], 'jpg', 'img');
                }
            }

            if (!empty($message['document']) && is_array($message['document'])) {
                $mime = (string)($message['document']['mime_type'] ?? '');
                $ext = pathinfo((string)($message['document']['file_name'] ?? ''), PATHINFO_EXTENSION) ?: 'bin';
                if (strpos($mime, 'video/') === 0) {
                    $filePath = $this->downloadTelegramFile((string)$message['document']['file_id'], $ext, 'file');
                    $extraHtml .= $this->mediaHtml($filePath, 'video');
                } elseif (strpos($mime, 'image/') === 0) {
                    $imagePath = $this->downloadTelegramFile((string)$message['document']['file_id'], $ext ?: 'jpg', 'img');
                } else {
                    $filePath = $this->downloadTelegramFile((string)$message['document']['file_id'], $ext, 'file');
                    $extraHtml .= $this->mediaHtml($filePath, 'file');
                }
            }
        } catch (\Throwable $e) {
            Yii::warning('Telegram media yuklanmadi: ' . $e->getMessage(), __METHOD__);
        }

        return [
            'title_uz' => $title,
            'content_uz' => $this->textToHtml($text) . $extraHtml,
            'category_id' => $this->categoryId,
            'status' => 1,
            'date' => $publishedAt,
            'slug' => $this->buildUniqueSlug($title),
            'seen' => 0,
            'img' => $imagePath,
            'file' => $filePath,
        ];
    }

    /** @param array<string,mixed> $payload */
    private function applyAttributes(\yii\db\ActiveRecord $model, array $payload, bool $isNew): void
    {
        foreach ($payload as $key => $value) {
            if (!$model->hasAttribute($key)) {
                continue;
            }
            if (!$isNew && in_array($key, ['slug', 'seen'], true)) {
                continue;
            }
            if ($value === null) {
                continue;
            }
            $model->setAttribute($key, $value);
        }

        foreach (['title_ru', 'title_en', 'content_ru', 'content_en'] as $nullable) {
            if (!$model->hasAttribute($nullable)) {
                continue;
            }
            if (in_array($nullable, ['title_ru', 'title_en'], true)) {
                $model->setAttribute($nullable, '');
                continue;
            }
            $model->setAttribute($nullable, null);
        }

        foreach (['img', 'file', 'file_en', 'file_ru'] as $pathField) {
            if (!$model->hasAttribute($pathField)) {
                continue;
            }
            $current = $model->getAttribute($pathField);
            if ($current === null || $current === '') {
                $model->setAttribute($pathField, '');
            }
        }

        if ($model->hasAttribute('who_create') && ($model->getAttribute('who_create') === null || $model->getAttribute('who_create') === '')) {
            $model->setAttribute('who_create', 'telegram');
        }
    }

    private function mediaHtml(?string $path, string $kind): string
    {
        if ($path === null || $path === '') {
            return '';
        }
        $safe = htmlspecialchars($path, ENT_QUOTES, 'UTF-8');
        if ($kind === 'video') {
            return '<p><video controls style="max-width:100%;height:auto" src="' . $safe . '"></video></p>';
        }
        return '<p><a href="' . $safe . '" target="_blank" rel="noopener noreferrer">' . $safe . '</a></p>';
    }

    private function buildTitle(string $text): string
    {
        $plain = trim(preg_replace('/\s+/u', ' ', strip_tags($text)) ?? '');
        if ($plain === '') {
            return 'Telegram yangiligi ' . date('Y-m-d H:i');
        }
        if (function_exists('mb_strlen') && mb_strlen($plain) > 180) {
            return rtrim(mb_substr($plain, 0, 177)) . '...';
        }
        if (strlen($plain) > 180) {
            return rtrim(substr($plain, 0, 177)) . '...';
        }
        return $plain;
    }

    private function textToHtml(string $text): string
    {
        if ($text === '') {
            return '';
        }
        $escaped = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        $html = '';
        foreach (preg_split("/\r\n|\r|\n/u", $escaped) ?: [] as $paragraph) {
            $paragraph = trim($paragraph);
            if ($paragraph === '') {
                continue;
            }
            $html .= '<p>' . $paragraph . '</p>';
        }
        return $html;
    }

    private function buildUniqueSlug(string $title): string
    {
        $base = Inflector::slug($title);
        if ($base === '') {
            $base = 'telegram-' . time();
        }
        $slug = $base;
        $suffix = 1;
        $modelClass = $this->postModelClass;
        while ($modelClass::find()->where(['slug' => $slug])->exists()) {
            $slug = $base . '-' . $suffix;
            $suffix++;
        }
        return $slug;
    }

    private function downloadTelegramFile(string $fileId, string $extension, string $bucket): string
    {
        $getFileUrl = 'https://api.telegram.org/bot' . rawurlencode($this->botToken) . '/getFile?file_id=' . rawurlencode($fileId);
        $response = $this->httpGetJson($getFileUrl);
        $filePath = (string)($response['result']['file_path'] ?? '');
        if ($filePath === '') {
            throw new RuntimeException('Telegram file_path topilmadi');
        }

        $fileSize = (int)($response['result']['file_size'] ?? 0);
        if ($fileSize > $this->maxDownloadBytes) {
            throw new RuntimeException('Telegram fayl hajmi cheklovdan oshdi');
        }

        $downloadUrl = 'https://api.telegram.org/file/bot' . $this->botToken . '/' . $filePath;
        $subdir = $bucket === 'file' ? 'files' : 'img';
        $uploadRoot = Yii::getAlias('@webroot/uploads/' . $subdir . '/yangilikar/telegram');
        FileHelper::createDirectory($uploadRoot);

        $ext = preg_replace('/[^a-z0-9]/i', '', $extension) ?: 'bin';
        $safeName = 'tg_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        file_put_contents(
            $uploadRoot . DIRECTORY_SEPARATOR . $safeName,
            $this->httpGetBinary($downloadUrl, $this->maxDownloadBytes)
        );

        return '/uploads/' . $subdir . '/yangilikar/telegram/' . $safeName;
    }

    /** @return array<string,mixed> */
    private function httpGetJson(string $url): array
    {
        $decoded = json_decode($this->httpGetBinary($url, $this->maxDownloadBytes), true);
        if (!is_array($decoded) || !($decoded['ok'] ?? false)) {
            throw new RuntimeException('Telegram API xatosi');
        }
        return $decoded;
    }

    private function httpGetBinary(string $url, ?int $maxBytes = null): string
    {
        $maxBytes = $maxBytes ?? $this->maxDownloadBytes;
        if ($maxBytes <= 0) {
            $maxBytes = self::DEFAULT_MAX_DOWNLOAD_BYTES;
        }

        if (function_exists('curl_init')) {
            $buffer = '';
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 180,
                CURLOPT_WRITEFUNCTION => static function ($curl, string $data) use (&$buffer, $maxBytes) {
                    $length = strlen($data);
                    if ($length === 0) {
                        return 0;
                    }
                    if (strlen($buffer) + $length > $maxBytes) {
                        return 0;
                    }
                    $buffer .= $data;
                    return $length;
                },
            ]);
            $ok = curl_exec($ch);
            $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($ok === false || $code >= 400) {
                throw new RuntimeException('HTTP yuklab olish xatosi');
            }
            if (strlen($buffer) > $maxBytes) {
                throw new RuntimeException('Yuklab olingan fayl hajmi cheklovdan oshdi');
            }
            return $buffer;
        }

        $context = stream_context_create([
            'http' => [
                'timeout' => 180,
                'follow_location' => 1,
            ],
        ]);
        $body = file_get_contents($url, false, $context);
        if ($body === false) {
            throw new RuntimeException('HTTP yuklab olish xatosi');
        }
        if (strlen($body) > $maxBytes) {
            throw new RuntimeException('Yuklab olingan fayl hajmi cheklovdan oshdi');
        }
        return $body;
    }
}
