<?php
include './include_common.php';

class Ws
{

    const HOST = '0.0.0.0';
    const PORT = 8811;
    public $http = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        $this->ws->set(
        // task_worker_num 配置 Task 进程的数量。【默认值：未配置则不启动 task】
        // worker_num 设置启动的 Worker 进程数。【默认值：CPU 核数】
            [
                'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
                'document_root' => '/home/wwwroot/default/twj/test/swoole_saishi/html',//设置静态处理器的路径。类型为数组，默认不启用
                'worker_num' => 2,
                'task_worker_num' => 2,// 配置此参数后将会启用 task 功能。所以 Server 务必要注册 onTask、onFinish 2 个事件回调函数。如果没有注册，服务器程序将无法启动。
            ]
        );
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('workerstart', [$this, 'onWorkerStart']);
        $this->ws->on('request', [$this, 'onRequest']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->start();
    }

    public function onWorkerStart()
    {
        echo 'work';
    }

    /***
     * 握手,监听连接
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        // fd 放进redis 有序集合 [1,2,3]
        var_dump($request->fd . "\n");
        $redis = redisTest::getObj()->sadd('live_game_key', $request->fd);
    }

    /***
     * 发送数据给客户端
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo 'ser-push-message:' . $frame->data . "\n";
        $ws->push($frame->fd, 'server-push:' . date('Y-M-D H:i:s') . "\n");
    }

    /***
     * 握手
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response)
    {
        print_r($request);
        try {
            ob_start();
            if ($request->get) {
                $class = $request->get['class'];
                $func = $request->get['func'];
            } else {
                $class = $request->post['class'];
                $func = $request->post['func'];
            }
            $_POST['http_server'] = $this->ws;

            if (is_string($class)) {
                call_user_func([$class, $func], $request);
            }
            $res = ob_get_contents();
            ob_end_clean();
            $response->end($res);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

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
        $return_data = $this->switchTask($data);
        echo $return_data;
        return $return_data;
    }

    /***
     * task分类器
     * @param $data
     * @return string
     */
    public function switchTask($data)
    {
        switch ($data['taskType']) {
            case 'getCode':
                $task = task::sendSms($data['data']['phone']);
                if ($task) {
                    return '发送验证码成功' . PHP_EOL;
                } else {
                    return '发送验证码失败' . PHP_EOL;
                }
                break;
            default:
                return '检查taskType参数';
                break;
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

        // 关闭就需要去redis有序集合踢出
        redisTest::getObj()->srem('live_game_key',$fd);

    }
}

$obj = new Ws();