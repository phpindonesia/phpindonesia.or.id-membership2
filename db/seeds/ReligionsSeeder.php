<?php

use Phinx\Seed\AbstractSeed;

class ReligionsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'religion_id' => '1',
                'religion_name' => 'Kristen'
            ],
            [
                'religion_id' => '2',
                'religion_name' => 'Katolik'
            ],
            [
                'religion_id' => '3',
                'religion_name' => 'Islam'
            ],
            [
                'religion_id' => '4',
                'religion_name' => 'Hindu'
            ],
            [
                'religion_id' => '5',
                'religion_name' => 'Buddha'
            ],
            [
                'religion_id' => '6',
                'religion_name' => 'Others'
            ],
        ];

        $datas = $this->table('religions');
        $datas->insert($data)
              ->save();
    }
}
