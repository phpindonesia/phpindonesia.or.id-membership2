<?php

namespace Membership\Database;

class StatementCombination extends \Slim\PDO\Statement\StatementContainer
{
    /**
     * @inheritdoc
     */
    public function __toString()
    {
        // Remove `WHERE` prefix in whereClause string
        $sql = substr(trim($this->whereClause), 5);

        return '('.trim($sql).')';
    }
}
