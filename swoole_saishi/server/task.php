<?php

include './redisTest.php';

class task
{
    /***
     * 异步发送验证码
     */
    public function sendSms($phone)
    {

        // 发送短信
        $redis = redisTest::getObj();
        $code = 1234;
        $redis->set('mt_'.$phone, $code);
   }
}