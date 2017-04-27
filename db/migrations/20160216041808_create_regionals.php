<?php

use Phinx\Migration\AbstractMigration;

class CreateRegionals extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('regionals');
        $table->addColumn('regional_name', 'string', array('limit' => 64))
              ->addColumn('parent_id', 'integer', array('null' => true, 'default' => null))
              ->addColumn('province_code', 'string', array('limit' => 4))
              ->addColumn('city_code', 'string', array('limit' => 4, 'null' => true, 'default' => null))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('regionals');
    }
}
