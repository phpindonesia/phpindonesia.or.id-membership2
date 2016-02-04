<?php
namespace Membership\Models;

use Membership\Models;

class Careers extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $destructive = true;

    /**
     * {@inheritdoc}
     */
    protected $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;

    /**
     * Retrieve career levels
     *
     * @return array
     */
    public function getLevels()
    {
        $query = $this->db->select()->from('career_levels')->orderBy('order_by', 'ASC');

        return $query->execute()->fetchAll();
    }

    /**
     * Retrieve career industries
     *
     * @return array
     */
    public function getIndustries()
    {
        $query = $this->db->select()->from('industries')->orderBy('industry_id');

        return $query->execute()->fetchAll();
    }

    /**
     * Retrieve career jobs
     *
     * @return array
     */
    public function getJobs()
    {
        $query = $this->db->select()->from('jobs')->orderBy('job_id');

        return $query->execute()->fetchAll();
    }
}
