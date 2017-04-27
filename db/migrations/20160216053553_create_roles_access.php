<?php

use Phinx\Migration\AbstractMigration;

class CreateRolesAccess extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('roles_access', array('id' => 'role_access_id'));
        $table->addColumn('role_id', 'integer')
              ->addColumn('functional_id', 'integer')
              ->addColumn('created', 'datetime')
              ->addColumn('created_by', 'integer')
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->addIndex(array('role_id', 'functional_id'), array('unique' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('roles_access');
    }
}
