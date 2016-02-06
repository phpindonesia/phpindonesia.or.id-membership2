<?php
namespace Membership;

use Slim\PDO\Database;
use Slim\PDO\Statement\StatementContainer;
use InvalidArgumentException;

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
     * @var \Slim\Interfaces\CollectionInterface|null
     */
    private $session = null;

    /**
     * @param \Slim\PDO\Database $db
     */
    public function __construct(Database $db, $session = null)
    {
        $this->db = $db;
        $this->session = $session;
    }

    /**
     * Retrieve current user session
     *
     * @param string $key
     * @param string $default
     * @return int
     */
    protected function current($key = null, $default = null)
    {
        if (is_null($this->session)) {
            return $default;
        }

        if (!is_null($key)) {
            return $this->session->get($key, $default);
        }

        return $this->session;
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

        $this->authorize('create', $pairs);

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
     * @param string[]           $columns Array of column
     * @param callable|array|int $terms   column value pairs of term data you wanna find to
     * @return \PDOStatement|false
     */
    public function get(array $columns = [], $terms = null)
    {
        if (!$this->table) {
            return false;
        }

        $query = $this->db->select($columns)->from($this->table);

        $this->normalizeTerms($query, $terms);

        return $query->execute();
    }

    /**
     * Find existing item(s) from table
     *
     * @param callable|array|int $terms column value pairs of term data you wanna find to
     * @return \PDOStatement|false
     */
    public function find($terms = null)
    {
        return $this->get([], $terms);
    }

    /**
     * Update existing item from table
     *
     * @param array              $pairs column value pairs of data
     * @param callable|array|int $terms column value pairs of term data you wanna update to
     * @return int|false
     */
    public function update(array $pairs, $terms = null)
    {
        if (!$this->table) {
            return false;
        }

        $this->authorize('update', $pairs);

        $query = $this->db->update(array_filter($pairs))->table($this->table);

        $this->normalizeTerms($query, $terms);

        return $query->execute();
    }

    /**
     * Delete Item from table
     *
     * @param callable|array|int $terms
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
     * @param callable|array|int $terms Use it if you want more terms
     * @param string             $column   Column to count
     * @param bool               $distinct Need a distinct count?
     * @return int
     */
    public function count($terms = null, $column = '', $distinct = false)
    {
        if (!$this->table) {
            return 0;
        }

        $query = $this->db->select()->count(($column ?: '*'), 'count', $distinct)->from($this->table);

        $this->normalizeTerms($query, $terms);

        return (int) $query->execute()->fetch()['count'];
    }

    /**
     * Normalize query terms
     *
     * @param \Slim\PDO\Statement\StatementContainer $query
     * @param callable|array|int                     $terms
     * @return void
     */
    protected function normalizeTerms(StatementContainer $query, &$terms)
    {
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
     * Authorize all input pairs
     *
     * @param string   $type
     * @param string[] $pairs
     */
    protected function authorize($type, &$pairs)
    {
        if (!in_array($type, ['update', 'create'])) {
            throw new InvalidArgumentException(
                sprintf('Authorization type must be between create or update only, %s given', $type)
            );
        }

        if (true === $this->authorize) {
            if ($type === 'create' && !isset($pairs['created_by'])) {
                $pairs['created_by'] = $this->current('user_id') ?: 0;
                $pairs['modified_by'] = 0;
            }

            if ($type === 'update' && !isset($pairs['modified_by'])) {
                $pairs['modified_by'] = $this->current('user_id') ?: 0;
            }
        }

        if (true === $this->timestamps) {
            $newDate = date('Y-m-d h:i:s');
            if ($type === 'create' && !isset($pairs['created'])) {
                $pairs['created'] = $newDate;
            }

            if ($type === 'update' && !isset($pairs['modified'])) {
                $pairs['modified'] = $newDate;
            }
        }
    }
}
