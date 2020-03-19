<?php
ini_set("display_errors", "off");
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth(123456);
while (true) {
    if ($redis->lLen('ooo') + 1 > 120) {// 初次访问，如果已满
        echo '队列已满';
        break;
    }
    //设置键的过期时间
    $key = 'lock';
    $redis->set($key, 1);
    $redis->setTimeout($key, 1);// 有效期1秒
    if ($redis->exists('sss')) {

        $int = $redis->lPush('ooo', '1');
        if ($int + 1 > 120) {// 队列长度为120 就提示队列已满，退出循环 固定队列长度的作用
            echo $int;
            echo '队列已满';
            break;
        }
    } else {
        break;
    }
}


