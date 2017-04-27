<?php

use Phinx\Migration\AbstractMigration;

class CreateMembersPortfolios extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('members_portfolios', array('id' => 'member_portfolio_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('company_name', 'string', array('limit' => 64))
              ->addColumn('industry_id', 'integer')
              ->addColumn('start_date_y', 'string', array('limit' => 4))
              ->addColumn('start_date_m', 'string', array('limit' => 2, 'null' => true, 'default' => null))
              ->addColumn('start_date_d', 'string', array('limit' => 2, 'null' => true, 'default' => null))
              ->addColumn('end_date_y', 'string', array('limit' => 4, 'null' => true, 'default' => null))
              ->addColumn('end_date_m', 'string', array('limit' => 2, 'null' => true, 'default' => null))
              ->addColumn('end_date_d', 'string', array('limit' => 2, 'null' => true, 'default' => null))
              ->addColumn('work_status', 'string', array('limit' => 1, 'comment' => 'A => Active, R = Resign'))
              ->addColumn('job_title', 'string', array('limit' => 64))
              ->addColumn('job_desc', 'string', array('limit' => 256, 'null' => true, 'default' => null))
              ->addColumn('career_level_id', 'string', array('limit' => 16))
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
        $this->dropTable('members_portfolios');
    }
}
