<?php

namespace Membership;

class Collection extends \Slim\Collection
{
    /**
     * @param string|array $keys
     * @return static
     */
    public function only(...$keys)
    {
        $data = [];

        foreach ($keys as $key) {
            if ($this->has($key)) {
                $data[$key] = $this->get($key);
            }
        }

        return new static($data);
    }

    public function values()
    {
        return array_values($this->data);
    }

    public function filter($callable = null, $flag = 0)
    {
        return array_filter($this->data, $callable, $flag);
    }
}
