<?php

use Phinx\Migration\AbstractMigration;

class CreateMembersSocmeds extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('members_socmeds', array('id' => 'member_socmed_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('socmed_type', 'string', array('limit' => 16))
              ->addColumn('account_name', 'string', array('limit' => 64, 'null' => true, 'default' => null))
              ->addColumn('account_url', 'string', array('limit' => 128, 'null' => true, 'default' => null))
              ->addColumn('created', 'datetime')
              ->addColumn('modified', 'datetime', array('null' => true, 'default' => null))
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->addIndex(array('user_id', 'socmed_type'), array('unique' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('members_socmeds');
    }
}
