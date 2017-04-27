<?php

use Phinx\Migration\AbstractMigration;

class CreateReligions extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('religions', array('id' => 'religion_id'));
        $table->addColumn('religion_name', 'string', array('limit' => 32))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('religions');
    }
}
