<?php
include './zhibo.php';
// 需要在cli运行，不然会报错的
// httpserver 是基于server的
// 监听0.0.0.0 表示监听所有地址
$http = new swoole_http_server('0.0.0.0', 8811);

$http->set(
    [
        'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
        'document_root' => '/home/wwwroot/default/twj/swoole/data',//设置静态处理器的路径。类型为数组，默认不启用
        'worker_num' => 5,
    ]
);
// 上面$htt->set()，如果它有静态资源，就不会再走后面的逻辑了


// $request 请求
// $response 响应
$http->on('request', function ($request, $response) {

    ob_start();
    $zhibo = new zhibo();
    $zhibo->index();
    $res = ob_get_contents();
    ob_end_clean();
    // 如果要把数据放在浏览器，就要用end()这个方法,而且必须要是string
    $response->end($res);

});
$http->start();