<?php

use Phinx\Migration\AbstractMigration;

class CreateIndustries extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('industries', array('id' => 'industry_id'));
        $table->addColumn('industry_name', 'string', array('limit' => 128))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('industries');
    }
}
