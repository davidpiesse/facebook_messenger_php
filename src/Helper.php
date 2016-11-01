<?php

namespace mapdev\FacebookMessenger;

class Helper
{
    /**
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed|null
     * Used for easily finding values in a FB Callback response
     */
    public static function array_find($array, $key, $default = null)
    {
        if (array_has($array, $key))
            return array_get($array, $key);
        else
            return $default;
    }

    /**
     * @param $mid
     * @return array
     * For converting a MID into a timestamp / datetime & UID
     */
    public static function MidConverter($mid)
    {
        $str_arr = preg_split('/[.,:]+/', $mid);;
        $result = [];
        $result['timestamp'] = $str_arr[1];
        $result['datetime'] = \Carbon\Carbon::createFromTimestamp($result['timestamp'] / 1000);
        $result['id'] = $str_arr[2];
        return $result;
    }
}