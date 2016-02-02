<?php
namespace Membership\Models;

use Membership\Models;

class MemberSocmeds extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'members_socmeds';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'member_socmed_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;
}
