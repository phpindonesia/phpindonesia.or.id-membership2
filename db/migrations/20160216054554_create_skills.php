<?php

use Phinx\Migration\AbstractMigration;

class CreateSkills extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('skills', array('id' => 'skill_id'));
        $table->addColumn('parent_id', 'integer', array('null' => true, 'default' => null))
              ->addColumn('skill_name', 'string', array('limit' => 256))
              ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('modified', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('skills');
    }
}
