<?php
ini_set("display_errors", "off");
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth(123456);
$llen = 120;// 队列固定的长度
$key = 'lock';// 锁的名字
while (true) {
    if ($redis->lLen('ooo') + 1 > $llen) {// 初次进来的判断
        echo '队列已满';
        break;
    }
    $redis->set($key, 1);
    //设置键的过期时间
    $redis->setTimeout($key, 1);// 锁的有效时间  1秒
    if ($redis->exists($key)) {// 拿到锁，解决并发

        $int = $redis->lPush('ooo', '1');
        if ($int + 1 > $llen) {// 提示队列已满 固定队列长度
            echo '队列已满';
            break;
        }
    } else {// 没拿到锁
        break;
    }
}


