<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Membership\Libraries;

use Slim\PDO\Database as SlimDatabase;

class Database extends SlimDatabase
{
    /**
     * @param array $columns
     *
     * @return Database\SelectStatement
     */
    public function select(array $columns = ['*'])
    {
        return new Database\SelectStatement($this, $columns);
    }
}
