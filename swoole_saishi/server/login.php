<?php

class login
{
    /***
     * 获取验证码
     */
    public function getCode($request)
    {
        $phone = $request->post['phone'];

        $http = $_POST['http_server'];
        $http->task($phone);
    }


}

