<?php

use Phinx\Migration\AbstractMigration;

class CreateJobs extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('jobs', array('id' => false, 'primary_key' => array('job_id')));
        $table->addColumn('job_id', 'string', array('limit' => 16))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('jobs');
    }
}
