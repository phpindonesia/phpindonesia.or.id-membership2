<?php
namespace Membership\Models;

use Membership\Models;

class Jobs extends Models
{
    public function getIds()
    {
        $query = $this->db->select(['job_id'])
            ->from('jobs')
            ->execute();

        return $query->fetchAll();
    }
}
