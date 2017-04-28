<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Membership\Libraries\Database;

class StatementCombination extends \Slim\PDO\Statement\StatementContainer
{
    public function __toString()
    {
        // Remove `WHERE` prefix in whereClause string
        $sql = substr(trim($this->whereClause), 5);

        return '('.trim($sql).')';
    }
}
