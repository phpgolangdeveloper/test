<?php
include "./zhibo.php";
include "./login.php";
include "./task.php";

class Http
{

    const HOST = '0.0.0.0';
    const PORT = 8811;
    public $http = null;

    public function __construct()
    {
        $this->http = new Swoole_http_server(self::HOST, self::PORT);
        $this->http->set(
        // task_worker_num 配置 Task 进程的数量。【默认值：未配置则不启动 task】
        // worker_num 设置启动的 Worker 进程数。【默认值：CPU 核数】
            [
                'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
                'document_root' => '/home/wwwroot/default/twj/test/swoole_saishi/html',//设置静态处理器的路径。类型为数组，默认不启用
                'worker_num' => 2,
                'task_worker_num' => 2,// 配置此参数后将会启用 task 功能。所以 Server 务必要注册 onTask、onFinish 2 个事件回调函数。如果没有注册，服务器程序将无法启动。
            ]
        );
//        $this->http->on('workerstart', [$this, 'onWorkerStart']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('task', [$this, 'onTask']);
        $this->http->on('finish', [$this, 'onFinish']);
        $this->http->on('close', [$this, 'onClose']);
        $this->http->start();
    }

//    public function onWorkerStart()
//    {
//
//    echo 'work';
//    }

    public function onRequest($request, $response)
    {
        print_r($request);
        ob_start();
        $class = $request->post['class'];
        $func = $request->post['func'];
        $phone = $request->post['phone'];

        if (is_string($class)) {
            call_user_func([$class, $func]);
        }
        if ($class && $func && $phone) {
            $this->http->task($phone);
        } else {
            echo '参数错误';
        }
        $res = ob_get_contents();
        ob_end_clean();
        $response->end($res);
    }

    /***
     * @param $ws http 或者 ws的对象
     * @param $task_id 任务ID
     * @param $workerId
     * @param $data $ws->task($data);投递的任务
     */
    public function onTask($serv, $taskId, $workerId, $data)
    {
        echo 'onTask-taskId：' . $taskId . PHP_EOL;
        echo 'onTask-workerId:' . $workerId . PHP_EOL;
        $task = task::sendSms($data);
        var_dump($data);
        if ($task) {
            return '发送验证码成功' . PHP_EOL;
        } else {
            return '发送验证码失败' . PHP_EOL;
        }
    }

    /***
     * @param $serv
     * @param $taskId
     * @param $data onTask的返回值
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo 'onFinish-taskId:' . $taskId . "\n";
        echo 'onFinish-data-sucess:' . $data . "\n";
    }

    public function onClose($ws, $fd)
    {
        echo 'clientid:' . $fd . "\n";
    }
}

$obj = new Http();