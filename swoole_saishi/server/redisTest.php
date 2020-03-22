<?php

class redisTest
{

    protected static $redis = null;

    final protected function __construct()
    {
    }

    protected function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getObj()
    {
        if (!self::$redis) {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            self::$redis = $redis;
        }
        return self::$redis;
    }

}