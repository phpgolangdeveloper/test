<?php

class login
{
    /***
     * 获取验证码
     */
    public function getCode($request)
    {
        $data = [
            'taskType' => 'getCode',
            'data' => ['phone' => $request->post['phone']]
        ];
        $http = $_POST['http_server'];
        $http->task($data);
    }

    public function loginType($request)
    {
        $phone = $request->post['phone'];
        $type = $request->post['type'];
        $code = $request->post['code'];
        switch ($type) {
            case 'typeLogin':
                $redis = redisTest::getObj();
                $redisCode = $redis->hget('phone_code', 'mt_' . $phone);
                if ($code == $redisCode) {
                    $bool = true;
                } else {
                    $bool = false;
                }
                break;
            default:
                break;
        }
        return $bool;
    }

}

