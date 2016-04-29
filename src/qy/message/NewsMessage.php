<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class NewsMessage
 * @package cdcchen\wechat\qy\message
 */
class NewsMessage extends Message
{
    /**
     * @inheritdoc
     */
    protected function init()
    {
        parent::init();
        $this->setMsgType(self::TYPE_NEWS);
    }

    /**
     * @param \cdcchen\wechat\qy\material\NewsArticle[] $articles
     * @return $this
     * @throws \Exception
     */
    public function setArticles($articles)
    {
        return $this->setContent($articles);
    }
}