<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 如果终端写了信息，$data就有值
$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "Hello World!";


$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// queue_declare 生命队列
$channel->queue_declare('task_queue', false, false, false, false);

$msg = new AMQPMessage($data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT) # 使消息持久化
);

//发送消息
//
//#$msg object AMQPMessage对象
//#$exchange string 交换机名字
//#$routing_key string 路由键 如果交换机类型
//fanout： 该值会被忽略，因为该类型的交换机会把所有它知道的队列发消息，无差别区别
//direct  只有精确匹配该路由键的队列，才会发送消息到该队列
//topic   只有正则匹配到的路由键的队列，才会发送到该队列
$channel->basic_publish($msg, '', 'task_queue');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();