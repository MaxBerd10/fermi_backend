<?php

use yii\db\Migration;

/**
 * Tracks processed Telegram channel posts to prevent duplicate news entries.
 */
class m260821_000000_create_telegram_import_log_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%telegram_import_log}}', [
            'id' => $this->primaryKey()->unsigned(),
            'chat_id' => $this->bigInteger()->notNull(),
            'message_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->unsigned()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->createIndex(
            'uq_tg_chat_message',
            '{{%telegram_import_log}}',
            ['chat_id', 'message_id'],
            true
        );

        $this->createIndex('idx_tg_post_id', '{{%telegram_import_log}}', 'post_id');
    }

    public function down()
    {
        $this->dropTable('{{%telegram_import_log}}');
    }
}
