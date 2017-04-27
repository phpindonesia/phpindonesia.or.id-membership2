<?php

use Phinx\Migration\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('users', array('id' => false, 'primary_key' => array('user_id')));
        $table->addColumn('user_id', 'integer', array('limit' => 10, 'signed' => false))
              ->addColumn('username', 'string', array('limit' => 32))
              ->addColumn('password', 'string', array('limit' => 32))
              ->addColumn('email', 'string', array('limit' => 32))
              ->addColumn('province_id', 'integer')
              ->addColumn('city_id', 'integer')
              ->addColumn('area', 'string', array('limit' => 255, 'null' => true, 'default' => null))
              ->addColumn('activated', 'string', array('limit' => 1, 'default' => 'N'))
              ->addColumn('created', 'datetime')
              ->addColumn('modified', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('created_by', 'integer')
              ->addColumn('modified_by', 'integer', array('null' => true, 'default' => null))
              ->addColumn('last_login', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->addIndex(array('username', 'email'), array('unique' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
