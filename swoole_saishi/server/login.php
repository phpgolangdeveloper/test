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
                $redisCode = $redis->hget(redisTest::SAISHI_PHONE_CODE, 'mt_' . $phone);
                if ($code == $redisCode) {
                    // 登录成功后存储信息到redis
                    $redis->hget(redisTest::SAISHI_USER_DATA, 'user_date'.$phone, $phone);
                    $bool = true;
                } else {
                    $bool = false;
                }
                break;
            default:
                break;
        }
        var_dump($bool);
        return $bool;
    }

}

