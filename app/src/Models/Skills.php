<?php
namespace Membership\Models;

use Membership\Models;

class Skills extends Models
{
    public function getChilds($parent)
    {
        $stmt = $this->db->select(['skill_id', 'skill_name'])
            ->from('skills')->where('parent_id', '=', $parent);

        return $stmt->execute()->fetchAll();
    }

    public function getParents()
    {
        $stmt = $this->db->select(['skill_id', 'skill_name'])
            ->from('skills')
            ->whereNull('parent_id');

        return $stmt->execute()->fetchAll();
    }
}
