<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersRoles extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('users_roles', array('id' => 'user_role_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('role_id', 'string', array('limit' => 16))
              ->addColumn('created', 'datetime')
              ->addColumn('created_by', 'integer')
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->addIndex(array('user_id', 'role_id'), array('unique' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users_roles');
    }
}
