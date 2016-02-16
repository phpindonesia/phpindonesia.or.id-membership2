<?php

use Phinx\Migration\AbstractMigration;

class CreateRoles extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('roles', array('id' => false, 'primary_key' => array('role_id')));
        $table->addColumn('role_id', 'string', array('limit' => 16, 'default' => ''))
              ->addColumn('title_alias', 'string', array('limit' => 64, 'null' => true, 'default' => null))
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('roles');
    }
}
