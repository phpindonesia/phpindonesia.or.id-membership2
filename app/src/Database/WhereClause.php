<?php

namespace Membership\Database;

class WhereClause extends \Slim\PDO\Clause\WhereClause
{
    /**
     * @param string|StatementCombination $column
     * @param string $operator
     * @param string $chainType
     */
    public function where($column, $operator = null, $chainType = 'AND')
    {
        $this->container[] = $column instanceof StatementCombination
            ? ' '.$chainType.' '.$column
            : ' '.$chainType.' '.$column.' '.$operator.' ?';
    }
}
