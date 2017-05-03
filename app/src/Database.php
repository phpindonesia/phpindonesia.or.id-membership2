<?php

namespace Membership;

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

    /**
     * Create new database transaction using callback that will automaticaly rolled back when failed.
     *
     * @param callable $callback
     * @return bool
     * @throws \Throwable
     */
    public function transaction(callable $callback)
    {
        $this->beginTransaction();

        try {
            $callback();

            return $this->commit();
        } catch (\PDOException $e) {
            $this->rollBack();

            throw $e;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
