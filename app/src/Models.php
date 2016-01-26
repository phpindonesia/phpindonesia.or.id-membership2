<?php
namespace Membership;

use Slim\PDO\Database;

abstract class Models
{
    /**
     * @var \Slim\PDO\Database
     */
    protected $db;

    /**
     * @param \Slim\PDO\Database $db
     */
    public static function factory(Database $db)
    {
        $self = new static;
        $self->db = $db;

        return $self;
    }
}
