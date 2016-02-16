<?php

use Phinx\Migration\AbstractMigration;

class CreateCareerLevels extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('career_levels', array('id' => false, 'primary_key' => array('career_level_id')));
        $table->addColumn('career_level_id', 'string', array('limit' => 16))
              ->addColumn('order_by', 'integer')
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('career_levels');
    }
}
