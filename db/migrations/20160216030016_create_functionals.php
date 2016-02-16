<?php

use Phinx\Migration\AbstractMigration;

class CreateFunctionals extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('functionals', array('id' => 'functional_id'));
        $table->addColumn('parent_id', 'integer', array('null' => true, 'default' => null))
              ->addColumn('functional_title', 'string', array('limit' => 128))
              ->addColumn('functional_url', 'string', array('limit' => 128))
              ->addColumn('created', 'datetime')
              ->addColumn('modified', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('created_by', 'integer')
              ->addColumn('modified_by', 'integer', array('null' => true, 'default' => null))
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('functionals');
    }
}
