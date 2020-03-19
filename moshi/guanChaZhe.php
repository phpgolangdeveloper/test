<?php
// php 实现观察者
// php5中提供观察者observer与被观察者subject的接口

// user ab 是被观察
// SplSubject 实现这个接口就要实现三个方法
class user implements SplSubject
{
    public $lognum;
    public $hobby;
    protected $observers = null;

    public function __construct($hobby)
    {
        $this->lognum = rand(1, 10);
        $this->hobby = $hobby;
        $this->observers = new SplObjectStorage();
    }

    /***
     * 登录
     */
    public function login()
    {
        // 操作session
        $this->notify();// 调用了，将观察的东西都给我通知！
    }

    // 1 第一个方法 附加，附加一个SplObserver，以便可以将其通知更新。
    public function attach(SPLObserver $observer)
    {
        $this->observers->attach($observer);
    }

    // 2 第二个方法 分离，将观察者从主题上移开，不再通知其更新。
    public function detach(SPLObserver $observer)
    {
        $this->observers->detach($observer);
    }

    // 3 第三个方法 通知，通知所有附加的观察者。
    public function notify()
    {
        $this->observers->rewind();
        // rewind 里面存储了很多要通知的对象, 将迭代器后退到第一个存储元素
        // valid 不断判断里面的对象
        // current 获取里面的对象
        // update 接收主题更新
        // next 下一个
        while ($this->observers->valid()) {
            $observer = $this->observers->current();
            $observer->update($this);
            $this->observers->next();
        }
    }
}

// 登录安全的
class secrity implements SPLObserver
{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        if ($subject->lognum < 3) {
            echo "这是第" . $subject->lognum . '次安全登录';
        } else {
            echo "这是第" . $subject->lognum . '次安全，异常';
        }
    }
}

// 对应的人返回对应的需求
class ad implements SPLObserver
{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        if ($subject->hobby == 'sports') {
            echo '台球英锦赛门票预订';
        } else {
            echo '好好学习，天天向上';
        }
    }
}

// 实施观察
$user = new user('study');
$user->attach(new secrity());// 观察它
$user->attach(new ad()); // 观察它
$user->login();


