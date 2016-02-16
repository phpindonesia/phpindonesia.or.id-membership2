<?php

use Phinx\Seed\AbstractSeed;

class RolesSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'role_id' => 'admin-regional',
                'title_alias' => 'Administrator Regional',
                'deleted' => 'N'
            ],
            [
                'role_id' => 'admin-super',
                'title_alias' => 'Administrator General',
                'deleted' => 'N'
            ],
            [
                'role_id' => 'member',
                'title_alias' => 'Member',
                'deleted' => 'N'
            ],
            [
                'role_id' => 'volunteer',
                'title_alias' => 'Author Voluntary',
                'deleted' => 'N'
            ],
        ];

        $datas = $this->table('roles');
        $datas->insert($data)
              ->save();
    }
}
