<?php
namespace Membership\Models;

use Membership\Models;

class MemberSkills extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'members_skills';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'member_skill_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;
}
