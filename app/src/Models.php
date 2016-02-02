<?php
namespace Membership;

use Slim\PDO\Database;
use Slim\Collection;

abstract class Models implements \Countable
{
    /**
     * @var \Slim\PDO\Database
     */
    protected $db;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var string
     */
    protected $primary = '';

    /**
     * @var bool
     */
    protected $destructive = false;

    /**
     * @var bool
     */
    protected $timestamps = true;

    /**
     * @var bool
     */
    protected $authorize = false;

    /**
     * @var array|null|\Slim\Interfaces\CollectionInterface
     */
    protected $current = null;

    /**
     * @param \Slim\PDO\Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
        // Anyone have better idea? :sweat_smile:
        if (isset($_SESSION['MembershipAuth']['user_id'])) {
            $this->current = new Collection($_SESSION['MembershipAuth']);
            $this->current->set('user_id', (int) $this->current->get('user_id'));
        }
    }

    /**
     * Retrieve current user id
     *
     * @param string $key Collection key
     * @return int
     */
    public function current($key = null, $default = null)
    {
        if (is_null($this->current)) {
            return $default;
        }

        if (!is_null($key)) {
            return $this->current->get($key, $default);
        }

        return $this->current;
    }

    /**
     * Create new data
     *
     * @param array $pairs column value pairs of data
     * @return int|false
     */
    public function create(array $pairs)
    {
        if (!$this->table) {
            return false;
        }

        if (true === $this->timestamps) {
            if (!isset($pairs['created'])) {
                $pairs['created'] = $this->freshDate();
            }
            $pairs['modified'] = null;
        }

        if (true === $this->authorize) {
            $pairs['create_by']   = $this->current('user_id') ?: 0;
            $pairs['modified_by'] = $this->current('user_id') ?: 0;
        }

        if (false === $this->destructive) {
            $pairs['deleted'] = 'N';
        }

        $query = $this->db->insert(array_keys($pairs))
            ->into($this->table)
            ->values(array_values($pairs));

        return (int) $query->execute(true);
    }

    /**
     * Get basic data
     *
     * @param string[]      $columns  Array of column
     * @param callable|null $callable [description]
     * @return \PDOStatement|false
     */
    public function get(array $columns = [], callable $callable = null)
    {
        if (!$this->table) {
            return false;
        }

        $query = $this->db->select($columns)->from($this->table);

        if (null !== $callable) {
            $callable($query);
        } else {
            if (false === $this->destructive) {
                $query->where('deleted', '=', 'N');
            }
        }

        return $query->execute();
    }

    /**
     * Find existing item(s) from table
     *
     * @param callable|array|numeric $terms column value pairs of term data you wanna find to
     * @return \PDOStatement|false
     */
    public function find($terms = null)
    {
        if (!$this->table) {
            return false;
        }

        $query = $this->db->select()->from($this->table);

        $this->normalizeTerms($query, $terms);

        return $query->execute();
    }

    /**
     * Update existing item from table
     *
     * @param array                  $pairs column value pairs of data
     * @param callable|array|numeric $terms column value pairs of term data you wanna update to
     * @return int|false
     */
    public function update(array $pairs, $terms = null)
    {
        if (!$this->table) {
            return false;
        }

        if (!isset($pairs['modified']) && true === $this->timestamps) {
            $pairs['modified'] = $this->freshDate();
        }

        if (true === $this->authorize) {
            $pairs['modified_by'] = $this->current('user_id') ?: 0;
        }

        $query = $this->db->update($pairs)->table($this->table);

        $this->normalizeTerms($query, $terms);

        return $query->execute();
    }

    /**
     * Delete Item from table
     *
     * @param callable|array|numeric $terms
     * @return int
     */
    public function delete($terms)
    {
        if (!$this->table) {
            return false;
        }

        if (false === $this->destructive) {
            return $this->update(['deleted' => 'Y'], $terms);
        }

        $query = $this->db->delete($this->table);

        $this->normalizeTerms($query, $terms);

        return $query->execute();
    }

    /**
     * Count all data
     *
     * @param callable|null $callable Use it if you want more terms
     * @param string        $column   Column to count
     * @param bool          $distinct Need a distinct count?
     * @return int
     */
    public function count(callable $callable = null, $column = '', $distinct = false)
    {
        if (!$this->table) {
            return 0;
        }

        $query = $this->db->count($column ?: '*', 'count', $distinct)->from($this->table);

        if (null !== $callable) {
            $callable($query);
        }

        return (int) $query->execute()->fetch()['count'];
    }

    /**
     * Normalize query terms
     *
     * @param \Slim\PDO\Statement\StatementContainer $query
     * @param callable|array|numeric                 $terms
     */
    protected function normalizeTerms($query, &$terms)
    {
        if (empty($query)) {
            return false;
        }

        if (is_callable($terms)) {
            $terms($query);
        } elseif (is_array($terms)) {
            foreach ($terms as $key => $value) {
                $sign = '=';
                if (strpos($key, ' ') !== false) {
                    list($key, $sign) = explode(' ', $key);
                }

                if (null !== $value) {
                    $query->where($key, $sign, $value);
                } else {
                    $query->whereNull($key);
                }
            }

            if (!isset($terms['deleted']) && false === $this->destructive) {
                $query->where('deleted', '=', 'N');
            }
        } elseif (is_numeric($terms) && !is_float($terms)) {
            $query->where($this->primary, '=', (int) $terms);

            if (false === $this->destructive) {
                $query->where('deleted', '=', 'N');
            }
        }
    }

    /**
     * Create new date
     *
     * @return string
     */
    protected function freshDate()
    {
        return date('Y-m-d h:i:s');
    }
}
