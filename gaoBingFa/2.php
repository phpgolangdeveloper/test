<?php
ini_set("display_errors", "off");
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth(123456);

if ($redis->lLen('ooo') >= 100) {// 大于或者等于xxx 就提示队列已满 固定队列长度
    echo '队列已满';
    exit;
}

if (!$redis->exists('sss')) {
    $redis->set('sss', 1,1000);
} else {
    $int = $redis->lPush('ooo', '1');
    echo $int;
}


