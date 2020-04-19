<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
//
//$host:  RabbitMQ服务器主机IP地址
//$port:  RabbitMQ服务器端口
//$user:  连接RabbitMQ服务器的用户名
//$password:  连接RabbitMQ服务器的用户密码
//$vhost:   连接RabbitMQ服务器的vhost（服务器可以有多个vhost，虚拟主机，类似nginx的vhost）

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

// 获取管道信息channel  接受一个参数，管道ID，可为空
$channel = $connection->channel();


//4、声明消费者队列 queue_declare
//（1）非持久化队列,RabbitMQ退出或者崩溃时，该队列就不存在
//（2）持久化队列（需要显示声明，第三个参数要设置为true），保存到磁盘，但不一定完全保证不丢失信息，因为保存总是要有时间的。
$channel->queue_declare('task_queue', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg){
    echo " [x] Received ", $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done", "\n";
};

#翻译时注：只有consumer已经处理并确认了上一条message时queue才分派新的message给它
$channel->basic_qos(null, 1, null);
#第四个参数 no_ack = false 时，表示进行ack应答，确保消息已经处理
#$callback 表示回调函数，传入消息参数
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);
#当no_ack=false时， 需要写下行代码，否则可能出现内存不足情况#$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);};

#监听消息，一有消息，立马就处理
while(count($channel->callbacks)) {
    $channel->wait();
}