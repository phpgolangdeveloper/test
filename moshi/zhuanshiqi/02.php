<?php
// 装饰器做文章修饰功能
// 父类是给你一个普通文章内容
// 两个子类是负责装饰
class BaseArt
{
    protected $art = null;
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function decorator()
    {
        return $this->content;
    }
}

// 编辑文章摘要
class BianArt extends BaseArt
{
    //这个construct是为了美化一篇文章，不是新增
    public function __construct(BaseArt $art)
    {
        $this->art = $art;
        $this->decorator();
    }

    public function decorator()
    {
        return $this->content = $this->art->decorator() . '小编摘要';
    }
}

// SEO加关键词
class SEOArt extends BaseArt
{
    //这个construct是为了美化一篇文章，不是新增
    public function __construct(BaseArt $art)
    {
        $this->art = $art;
        $this->decorator();
    }

    public function decorator()
    {
        return $this->content = $this->art->decorator() . 'SEO关键字';
    }
}

$b = new SEOArt(new BianArt(new BaseArt('天天向上')));
echo $b->decorator();

