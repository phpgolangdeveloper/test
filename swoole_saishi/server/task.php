<?php

include './redis.php';

class task
{
    /***
     * 异步发送验证码
     */
    public function sendSms($phone)
    {

        // 发送短信
        $redis = new redis();
        $code = 1234;
        $redis->set('mt_'.$phone, 1234);
   }
}