<?php

use Phinx\Seed\AbstractSeed;

class JobsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'job_id' => 'FREELANCER'
            ],
            [
                'job_id' => 'KARYAWAN'
            ],
            [
                'job_id' => 'MAHASISWA'
            ],
            [
                'job_id' => 'OWNER'
            ],
            [
                'job_id' => 'PELAJAR'
            ],
        ];

        $datas = $this->table('jobs');
        $datas->insert($data)
              ->save();
    }
}
