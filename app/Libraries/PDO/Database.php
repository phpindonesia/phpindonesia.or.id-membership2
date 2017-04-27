<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Membership\Libraries\PDO;

class Database extends \Slim\PDO\Database
{
    /**
     * @param array $columns
     *
     * @return SelectStatement
     */
    public function select(array $columns = array('*'))
    {
        return new SelectStatement($this, $columns);
    }
}
