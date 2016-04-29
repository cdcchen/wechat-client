<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class MPNewsMessage
 * @package cdcchen\wechat\qy\message
 */
class MPNewsMessage extends Message
{
    /**
     * @inheritdoc
     */
    protected function init()
    {
        parent::init();
        $this->setMsgType(self::TYPE_MPNEWS);
    }

    /**
     * @param \cdcchen\wechat\qy\material\MPNewsArticle[] $articles
     * @return $this
     * @throws \Exception
     */
    public function setArticles($articles)
    {
        return $this->setContent($articles);
    }
}