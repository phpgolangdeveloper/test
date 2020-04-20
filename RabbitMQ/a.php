<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();


$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');

//发送消息
//
//#$msg object AMQPMessage对象
//#$exchange string 交换机名字
//#$routing_key string 路由键 如果交换机类型
// fanout： 该值会被忽略，因为该类型的交换机会把所有它知道的队列发消息，无差别区别
//direct  只有精确匹配该路由键的队列，才会发送消息到该队列
//topic   只有正则匹配到的路由键的队列，才会发送到该队列
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();