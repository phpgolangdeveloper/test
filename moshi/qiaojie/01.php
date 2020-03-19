<?php

// 桥接模式

interface  msg
{
    public function send($to, $content);
}

class zn implements msg
{
    public function send($to, $content)
    {
        // TODO: Implement send() method.
        echo '站内信发给', $to, '内容', $content;
    }
}

class email implements msg
{
    public function send($to, $content)
    {
        // TODO: Implement send() method.
        echo 'email给', $to, '内容', $content;
    }
}

class sms implements msg
{
    public function send($to, $content)
    {
        // TODO: Implement send() method.
        echo '短信发给', $to, '内容', $content;
    }
}


// 内容也分普通，加急，特急
/*

class zncommon extends msg
class znwarn extends msg
class zndanger extends msg

class emailcommon extends msg
class emailwarn extends msg
class emaildanger extends msg
.....

思考：
信的发送方式是一个变化因素；
信得紧急程度是一个变化因素；
为了不修改父类，只好考虑2个因素得组合，不停产生新类...

 * */


