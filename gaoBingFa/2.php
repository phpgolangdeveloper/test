<?php
//echo 13;
//


// file_put_contents("client_1.txt", "client_1 execute:".time()."\r\n",FILE_APPEND);
// echo 'client_1 execute';
ini_set("display_errors", "off");
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis->auth(123456);


if ($redis->lLen('ooo') >= 10) {
    echo '队列已满';
    exit;
}

$int = $redis->lPush('ooo', '1');
echo $int;

