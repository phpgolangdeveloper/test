<?php

include './redisTest.php';

class task
{
    /***
     * 异步发送验证码
     */
    public static function sendSms($phone)
    {
        if (!$phone) {
            return 0;
        }
        // 发送短信
        $redis = redisTest::getObj();
        $code = 1234;
        $bool = $redis->hset(redisTest::SAISHI_PHONE_CODE, 'mt_' . $phone, $code);
        if ($bool) {
            return 1;
        }
        return 0;
    }
}