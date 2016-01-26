<?php
namespace Membership;

use Slim\PDO\Database;

abstract class Models
{
    /**
     * Slim\Container instance
     *
     * @var \Slim\PDO\Database
     */
    private $db;

    /**
     * Inject
     *
     * @param \Slim\PDO\Database $db
     */
    public static function factory(Database $db)
    {
        $self = new static;
        $self->db = $db;

        return $self;
    }
}
