<?php

use Phinx\Seed\AbstractSeed;

class CareerLevelsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'career_level_id' => 'VOLUNTEER',
                'order_by' => '1'
            ],
            [
                'career_level_id' => 'TRAINEE',
                'order_by' => '2'
            ],
            [
                'career_level_id' => 'STAFF',
                'order_by' => '3'
            ],
            [
                'career_level_id' => 'SUPERVISOR',
                'order_by' => '4'
            ],
            [
                'career_level_id' => 'ASST-MANAGER',
                'order_by' => '5'
            ],
            [
                'career_level_id' => 'MANAGER',
                'order_by' => '6'
            ],
            [
                'career_level_id' => 'GENERAL-MANAGER',
                'order_by' => '7'
            ],
            [
                'career_level_id' => 'DIREKTUR',
                'order_by' => '8'
            ],
        ];

        $datas = $this->table('career_levels');
        $datas->insert($data)
              ->save();
    }
}
