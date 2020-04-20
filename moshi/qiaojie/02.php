<?php

abstract class info
{

    protected $send = null;

    // 根据不同紧急程度造内容的方法
    abstract public function msg($content);
    public function __construct($send)
    {
        $this->send = $send;
    }
    public function send($to, $content)
    {
        $content = $this->msg($content);
        $this->send->send($to, $content);
    }
}

// 三个不同的发送类
// 发送站内
class zn
{
    public function send($to, $content)
    {
        echo '站内给:', $to, '内容是:', $content;
    }
}

// 发送email
class email
{
    public function send($to, $content)
    {
        echo 'email给:', $to, '内容是:', $content;
    }
}

// 发送短信
class sms
{
    public function send($to, $content)
    {
        echo 'sms给:', $to, '内容是:', $content;
    }
}

// 发送普通内容类
class commoninfo extends info
{
    public function msg($content)
    {
        return '普通内容：' . $content;
    }
}

// 发送紧急内容类
class warninfo extends info
{
    public function msg($content)
    {
        return '紧急内容：' . $content;
    }
}

// 发送特急内容类
class deangerinfo extends info
{
    public function msg($content)
    {
        return '特急内容：' . $content;
    }
}

// 用站内发普通信息
$commoninfo = new commoninfo(new zn());
$commoninfo->send('小明', '吃饭了');
echo "<br />";

//用手机发特急信息
$commoninfo = new deangerinfo(new sms());
$commoninfo->send('小刚', '火柱了，快回家');