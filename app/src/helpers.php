<?php

if (!function_exists('array_pairs')) {
    /**
     * Combine array into single key value pairs
     *
     * @param array       $values
     * @param string      $key
     * @param string|null $val
     * @return array
     */
    function array_pairs(array $values, $key, $val = null)
    {
        $array = [];
        $val = $val ?: $key;

        foreach ($values as $value) {
            if (isset($value[$key]) && isset($value[$val])) {
                $array[$value[$key]] = $value[$val];
            }
        }

        return $array;
    }
}

if (!function_exists('array_flatten')) {
    /**
     * Flatten all array values
     *
     * @param array $array Array to be flatten
     * @return array
     */
    function array_flatten(array $array)
    {
        $array = array_values($array);
        return call_user_func_array('array_merge', $array);
    }
}

if (!function_exists('dd')) {
    /**
     * Doo-bee-doo-bee Dump
     */
    function dd()
    {
        array_map(function ($arg) {
            var_dump($arg);
        }, func_get_args());

        die(1);
    }
}

if (!function_exists('months')) {
    /**
     * Get month list
     *
     * @return array
     */
    function months()
    {
        return [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }
}

if (!function_exists('years_range')) {
    /**
     * Get years range
     *
     * @return array
     */
    function years_range()
    {
        $start_year = 1990;
        $end_year = (int) date('Y');
        $years_range = [];

        foreach (range($start_year, $end_year) as $item) {
            $item_str = (string) $item;
            $years_range[$item_str] = $item;
        }

        return $years_range;
    }
}

if (!function_exists('months_range')) {
    /**
     * Get month range
     *
     * @return array
     */
    function months_range()
    {
        $months = months();
        $months_range = [];

        foreach (range(1, 12) as $item) {
            $item_str = ''.$item;
            $item_str = strlen($item_str) > 1 ? $item_str : '0'.$item_str;
            $months_range[$item_str] = $months[$item_str];
        }

        return $months_range;
    }
}

if (!function_exists('days_range')) {
    /**
     * Get days range
     *
     * @return array
     */
    function days_range()
    {
        $days_range = [];

        foreach (range(1, 31) as $item) {
            $item_str = ''.$item;
            $item_str = strlen($item_str) > 1 ? $item_str : '0'.$item_str;
            $days_range[$item_str] = $item_str;
        }

        return $days_range;
    }
}
