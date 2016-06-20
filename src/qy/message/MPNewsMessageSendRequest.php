<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:13
 */

namespace cdcchen\wechat\qy\message;


use cdcchen\wechat\qy\material\MPNewsArticle;

/**
 * Class MPNewsMessageSendRequest
 * @package cdcchen\wechat\qy\message
 */
class MPNewsMessageSendRequest extends MediaMessageSendRequest
{
    /**
     * @var string
     */
    protected $msgType = Message::TYPE_MPNEWS;

    /**
     * @param MPNewsArticle[] $value
     * @return $this
     */
    public function setArticles($value)
    {
        return $this->setMsgType(Message::TYPE_MPNEWS)
                    ->setData('mpnews', static::buildArticles($value));
    }

    /**
     * @param MPNewsArticle[] $articles
     * @return array
     */
    private static function buildArticles(array $articles)
    {
        $items = [];
        foreach ($articles as $article) {
            $items[] = $article->toArray();
        }

        return $items;
    }
}