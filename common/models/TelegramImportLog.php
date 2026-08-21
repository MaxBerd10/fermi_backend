<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $message_id
 * @property int|null $post_id
 * @property string $created_at
 * @property string|null $updated_at
 */
class TelegramImportLog extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%telegram_import_log}}';
    }

    public function rules(): array
    {
        return [
            [['chat_id', 'message_id'], 'required'],
            [['chat_id', 'message_id', 'post_id'], 'integer'],
        ];
    }

    public static function findByMessage(int $chatId, int $messageId): ?self
    {
        return static::findOne(['chat_id' => $chatId, 'message_id' => $messageId]);
    }

    public static function remember(int $chatId, int $messageId, int $postId): void
    {
        $row = static::findByMessage($chatId, $messageId);
        if ($row === null) {
            $row = new static([
                'chat_id' => $chatId,
                'message_id' => $messageId,
            ]);
        }
        $row->post_id = $postId;
        if ($row->hasAttribute('updated_at')) {
            $row->updated_at = date('Y-m-d H:i:s');
        }
        $row->save(false);
    }
}
