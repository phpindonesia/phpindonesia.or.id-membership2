<?php

namespace Membership\Database;

use Membership\Database;

class SelectStatement extends \Slim\PDO\Statement\SelectStatement
{
    /**
     * @param Database $dbh  current session selected database
     * @param array $columns selected columns
     */
    public function __construct(Database $dbh, array $columns)
    {
        parent::__construct($dbh, $columns);

        $this->whereClause = new WhereClause();
    }

    /**
     * @param $column
     * @param null   $operator
     * @param null   $value
     * @param string $chainType
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $chainType = 'AND')
    {
        if ($column instanceof StatementCombination) {
            $this->setValues($column->values);
        } else {
            $this->values[] = $value;
        }

        $this->whereClause->where($column, $operator, $chainType);

        return $this;
    }

    /**
     * @return StatementCombination
     */
    public function combine()
    {
        return new StatementCombination($this->dbh);
    }
}
