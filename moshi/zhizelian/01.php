<?php
/***
 * 责任链模式 -> 找它的上级 -> 肯定要有一级是可以处理的
 */

class board
{
    protected $power = 1;
    protected $top = 'admin';// 上级

    // 版主删帖
    public function process($lev)
    {
        if ($lev <= $this->power) {
            echo '版主删帖';
        } else {
            $top = new$this->top;
            $top->process($lev);
        }
    }
}

class admin
{
    protected $power = 2;
    protected $top = 'police';// 上级

    public function process($lev)
    {
        if ($lev <= $this->power) {
            echo '管理员封号';
        } else {
            $top = new $this->top;
            $top->process($lev);
        }

    }
}

class police
{
    protected $top = null;
    protected $power;
    public function process()
    {
        echo '警察捉人';
    }
}

// 责任链模式来处理举报问题
$lev = $_POST['jubao'] + 0;

$judge = new board();
$judge->process($lev);