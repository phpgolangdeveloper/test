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
        $_POST['http_server']->push(1, 'hello');
    }
}