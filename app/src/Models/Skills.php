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

    /**
     * Get main skill list
     *
     * @return array
     */
    public function getParents()
    {
        $result = $this->get(['skill_id', 'skill_name'], function ($query) {
            $query->whereNull('parent_id');
        });

        return $result->fetchAll();
    }

    /**
     * Get sub skill list
     *
     * @param int $parentId Parent ID
     * @return array
     */
    public function getChilds($parentId = null)
    {
        if (is_null($parentId)) {
            return [];
        }

        $result = $this->get(['skill_id', 'skill_name'], function ($query) use ($parentId) {
            $query->where('parent_id', '=', (int) $parentId);
        });

        return $result->fetchAll();
    }
}
