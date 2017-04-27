<?php

use Phinx\Migration\AbstractMigration;

class CreateMembersSkills extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('members_skills', array('id' => 'member_skill_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('skill_id', 'integer')
              ->addColumn('skill_parent_id', 'integer')
              ->addColumn('skill_self_assesment', 'integer')
              ->addColumn('created', 'datetime')
              ->addColumn('modified', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('members_skills');
    }
}
