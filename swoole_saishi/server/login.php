<?php

class login {
    /***
     * 获取验证码
     */
    public function getCode() {
        return "1234";
    }

}
$request = $_REQUEST;
$class = new $request['class'];
$func = $request['func'];
