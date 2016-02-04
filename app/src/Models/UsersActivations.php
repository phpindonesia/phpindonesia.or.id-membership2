<?php
namespace Membership\Models;

use Membership\Models;

class UsersActivations extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'users_activations';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'user_activation_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;
}
