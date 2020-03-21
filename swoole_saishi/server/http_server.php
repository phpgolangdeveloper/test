<?php
include './zhibo.php';

class http_server
{
    private $http = null;

    public function __construct()
    {
        $this->http = new swoole_http_server('0.0.0.0', 8811);

        $this->http->set(
            [
                'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
                'document_root' => '/home/wwwroot/default/twj/swoole/data',//设置静态处理器的路径。类型为数组，默认不启用
                'worker_num' => 5,
            ]
        );

        $this->http->on('request', [$this, 'onRequest']);
        $this->http->start();
    }

    public function onRequest($request, $response)
    {

        ob_start();
        $zhibo = new zhibo();
        $zhibo->detaile();
        $res = ob_get_contents();
        ob_end_clean();
        // 如果要把数据放在浏览器，就要用end()这个方法,而且必须要是string
        $response->end($res);

    }

}

new http_server();