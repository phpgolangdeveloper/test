<?php

class redis {
    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        return $redis;
    }


}