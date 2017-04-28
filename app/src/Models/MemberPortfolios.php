<?php
namespace Membership\Models;

use Membership\Models;

class MemberPortfolios extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'members_portfolios';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'member_portfolio_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = true;
}
