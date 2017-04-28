<?php
namespace Membership\Models;

use Membership\Models;

class Religions extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'religions';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'religion_id';

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
}
