<?php

use \yii\db\Migration;

/**
 * Adds a refresh_token column used by the api/ app's JWT auth (AuthController).
 * The JWT access token itself is stateless/signed and not stored; refresh_token
 * is an opaque random string persisted per-user so it can be rotated/revoked on logout.
 */
class m260722_000000_add_refresh_token_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'refresh_token', $this->string(255)->null()->defaultValue(null));
        $this->createIndex('idx-user-refresh_token', '{{%user}}', 'refresh_token', true);
    }

    public function down()
    {
        $this->dropIndex('idx-user-refresh_token', '{{%user}}');
        $this->dropColumn('{{%user}}', 'refresh_token');
    }
}
