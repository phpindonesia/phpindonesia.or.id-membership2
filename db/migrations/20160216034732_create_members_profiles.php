<?php

use Phinx\Migration\AbstractMigration;

class CreateMembersProfiles extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('members_profiles', array('id' => 'member_profile_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('fullname', 'string', array('limit' => 64))
              ->addColumn('contact_phone', 'string', array('limit' => 32, 'null' => true, 'default' => null))
              ->addColumn('photo', 'string', array('limit' => 128, 'null' => true, 'default' => null))
              ->addColumn('birth_place', 'string', array('limit' => 32, 'null' => true, 'default' => null))
              ->addColumn('birth_date', 'date', array('null' => true, 'default' => null))
              ->addColumn('identity_number', 'string', array('limit' => 32, 'null' => true, 'default' => null))
              ->addColumn('identity_type', 'string', array('limit' => 8, 'null' => true, 'default' => null))
              ->addColumn('religion_id', 'integer', array('null' => true, 'default' => null))
              ->addColumn('gender', 'string', array('limit' => 6))
              ->addColumn('province_id', 'integer')
              ->addColumn('city_id', 'integer')
              ->addColumn('area', 'string', array('limit' => 255, 'null' => true, 'default' => null))
              ->addColumn('job_id', 'string', array('limit' => 16, 'null' => true, 'default' => null))
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
        $this->dropTable('members_profiles');
    }
}
