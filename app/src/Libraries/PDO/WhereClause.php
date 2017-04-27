<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Membership\Libraries\PDO;

class WhereClause extends \Slim\PDO\Clause\WhereClause
{
    /**
     * @param string|StatementCombination $column
     * @param string $operator
     * @param string $chainType
     */
    public function where($column, $operator = null, $chainType = 'AND')
    {
        if ($column instanceof StatementCombination)
        {
            $this->container[] = ' '.$chainType.' '.$column;
        }
        else
        {
            $this->container[] = ' '.$chainType.' '.$column.' '.$operator.' ?';
        }
    }
}
