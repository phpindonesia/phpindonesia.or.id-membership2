<?php
namespace Membership\Models;

use Membership\Models;

class MemberProfile extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'members_profiles';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'members_profile_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;
}
