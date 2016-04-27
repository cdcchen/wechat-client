<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\message;


class NewsMessage extends Message
{
    protected function init()
    {
        parent::init();
        $this->setMsgType(self::TYPE_NEWS);
    }

    public function setArticles($articles)
    {
        return $this->setContent($articles);
    }
}