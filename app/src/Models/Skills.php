<?php
namespace Membership\Models;

use Membership\Models;

class Skills extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'skills';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'skill_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;

    public function getParents()
    {
        $result = $this->get(
            [$this->primary, 'skill_name'],
            ['parent_id' => null]
        );

        return $result->fetchAll();
    }

    public function getChilds($parentId)
    {
        $result = $this->get(
            [$this->primary, 'skill_name'],
            ['parent_id' => (int) $parentId]
        );

        return $result->fetchAll();
    }
}
