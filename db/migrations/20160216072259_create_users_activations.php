<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersActivations extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('users_activations', array('id' => 'user_activation_id'));
        $table->addColumn('user_id', 'integer')
              ->addColumn('activation_key', 'string', array('limit' => 32))
              ->addColumn('expired_date', 'datetime')
              ->addColumn('email_sent', 'string', array('limit' => 1, 'default' => 'N'))
              ->addColumn('created', 'datetime')
              ->addColumn('deleted', 'string', array('limit' => 1, 'default' => 'N'))
              ->addIndex(array('user_id', 'activation_key'), array('unique' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users_activations');
    }
}
