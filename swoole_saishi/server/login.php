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

    public function loginPhone($phone, $code)
    {
        $redis = redisTest::getObj();
        $redisCode = $redis->hget('phone_code', 'mt_'. $phone);
        var_dump($redisCode);
        var_dump($code);
        if ($code == $redisCode) {
            return 1;
        } else {
            return 0;
        }

    }

    public function loginType($request)
    {
        $phone = $request->post['phone'];
        $type = $request->post['type'];
        $code = $request->post['typeLogin'];
        switch ($type) {
            case 'typeLogin':
                $bool =   $this->loginPhone($phone, $code);
                break;
            default:
                break;
        }
        return $bool;
    }

}

