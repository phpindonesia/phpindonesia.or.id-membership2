<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersResetPwd extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('users_reset_pwd', array('id' => 'user_reset_pwd_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('reset_key', 'string', array('limit' => 32))
              ->addColumn('expired_date', 'datetime')
              ->addColumn('email_sent', 'string', array('limit' => 1, 'default' => 'N'))
              ->addColumn('created', 'datetime')
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users_reset_pwd');
    }
}
