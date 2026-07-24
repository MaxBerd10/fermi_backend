<?php

use \yii\db\Migration;

/**
 * Adds a role column to distinguish CMS admins from public site accounts.
 * The legacy backend/ AsosController only ever checked roles=>['@'] (any
 * authenticated user), so any public signup could reach every admin CRUD
 * screen. The new api/ admin endpoints gate on role='admin' instead.
 */
class m260724_000000_add_role_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'role', $this->string(20)->notNull()->defaultValue('user'));
        $this->update('{{%user}}', ['role' => 'admin'], ['id' => 1]);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'role');
    }
}
