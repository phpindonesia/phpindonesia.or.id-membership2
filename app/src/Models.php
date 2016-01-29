<?php
namespace Membership;

use Slim\PDO\Database;

abstract class Models
{
    /**
     * @var string
     */
    protected $table = '';

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

    /**
     * Get basic data
     *
     * @param  string[]      $columns  Array of column
     * @param  callable|null $callable [description]
     * @return \PDOStatement|false
     */
    public function get(array $columns = [], callable $callable = null)
    {
        if (!$this->table) {
            return false;
        }

        $query = $this->db->select($column)
            ->from($this->table);

        if (null !== $callable) {
            $callable($query);
        }

        return $query->execute();
    }

    /**
     * Create new data
     *
     * @param  array  $pairs column value pairs of data
     * @return int|false
     */
    public function create(array $pairs)
    {
        if (!$this->table) {
            return false;
        }

        if (!isset($pairs['created'])) {
            $pairs['created'] = date('Y-m-d h:i:s');
        }

        $pairs['modified'] = null;
        $query = $this->db->insert(array_keys($pairs))
            ->into($this->table)
            ->values(array_values($pairs));

        return (int) $query->execute(true);
    }

    /**
     * Update existing data
     *
     * @param  array          $pairs column value pairs of data
     * @param  callable|array $terms column value pairs of term data you wanna update to
     * @return int|false
     */
    public function update(array $pairs, $terms = null)
    {
        if (!$this->table) {
            return false;
        }

        if (!isset($pairs['modified'])) {
            $pairs['modified'] = date('Y-m-d h:i:s');
        }

        $query = $this->db->update($pairs)
            ->table($this->table);

        $this->normalizeTerms($query, $terms);

        return $query->execute();
    }

    /**
     * Count all data
     *
     * @param  callable|null $callable Use it if you want more terms
     * @param  string        $column   Column to count
     * @param  bool          $distinct Need a distinct count?
     * @return int
     */
    public function count(callable $callable = null, $column = '', $distinct = false)
    {
        $query = $this->db->count($column ?: '*', 'count', $distinct)->from($this->table);

        if (null !== $callable) {
            $callable($query);
        }

        return (int) $query->execute()->fetch()['count'];
    }

    /**
     * Normalize query terms
     *
     * @param  \Slim\PDO\Statement\StatementContainer $query
     * @param  callable|array                         $terms
     */
    protected function normalizeTerms($query, &$terms)
    {
        if (is_callable($terms)) {
            $terms($query);
        } elseif (is_array($terms)) {
            foreach ($terms as $key => $value) {
                $sign = '=';
                if (strpos($key, ' ') !== false) {
                    list($key, $sign) = explode(' ', $key);
                }

                $query->where($key, $sign, $value);
            }
        }
    }
}
