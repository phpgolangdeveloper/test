<?php

class admin
{

    public function image()
    {

        print_r($_FILES);

    }

    public function live()
    {
        print_r($_POST);

        // 1 把赛况基本信息入库

        // 2 把数据组装好 push 到直播页面
        // 第一种方法，通过redis中的有序集合来给每个客户端发消息，有序集合里面存储了客户端连接fd来辨别

        // mysql查到数据
        $teams = [
            1 => [
                'name' => '马刺',
                'logo' => 'png',
            ],
            4 => [
                'name' => '热火',
                'logo' => 'jpg',
            ],
        ];

        $data = [
            'type' => intval($_POST['type']),
            'title' => $_POST['name'],
            'logo' => 'jpg',
            'content' => $_POST['content'],
            'image' => 'png'
        ];


        $clients = redisTest::getObj()->sMembers('live_game_key');
        foreach ($clients as $fd) {
            $_POST['http_server']->push($fd, json_encode($data, true));
        }

//        $_POST['http_server']->push(1, 'hello');
    }
}