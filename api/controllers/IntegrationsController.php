<?php

namespace api\controllers;

use common\services\TelegramNewsImporter;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * POST /v1/integrations/telegram/webhook
 */
class IntegrationsController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        return $behaviors;
    }

    protected function verbs(): array
    {
        return [
            'telegram-webhook' => ['POST'],
        ];
    }

    public function actionTelegramWebhook(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $expectedSecret = trim((string)(Yii::$app->params['telegramWebhookSecret'] ?? getenv('TELEGRAM_WEBHOOK_SECRET') ?: ''));
        if ($expectedSecret === '') {
            throw new ForbiddenHttpException('Webhook secret sozlanmagan');
        }

        $providedSecret = (string)Yii::$app->request->headers->get('X-Telegram-Bot-Api-Secret-Token', '');
        if (!hash_equals($expectedSecret, $providedSecret)) {
            throw new ForbiddenHttpException('Noto‘g‘ri secret token');
        }

        $payload = Yii::$app->request->getBodyParams();
        if (!is_array($payload) || $payload === []) {
            $raw = Yii::$app->request->getRawBody();
            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) {
                throw new BadRequestHttpException('JSON body kerak');
            }
            $payload = $decoded;
        }

        if (!isset($payload['channel_post']) && !isset($payload['edited_channel_post'])) {
            return ['success' => true, 'data' => ['status' => 'ignored', 'reason' => 'unsupported_update']];
        }

        try {
            $result = (new TelegramNewsImporter())->handleUpdate($payload);
        } catch (ForbiddenHttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            Yii::$app->response->statusCode = 500;
            return ['success' => false, 'error' => 'import_failed'];
        }

        return ['success' => true, 'data' => $result];
    }
}
