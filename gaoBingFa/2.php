<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth(123456);

while (true) {

    $key = 'sss';
    $redis->set($key, 1);
    //设置键的过期时间
    $redis->setTimeout($key, 1);
    if ($redis->exists('sss')) {
        $redis->incr('num');
        $int = $redis->lPush('ooo', '1');
        if ($int ==100) {   
            break;
        }
    } else {
        break;
    }
}


