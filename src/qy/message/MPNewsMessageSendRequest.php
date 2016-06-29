<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:13
 */

namespace cdcchen\wechat\qy\message;


use cdcchen\wechat\qy\base\Message;

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
     * @param \cdcchen\wechat\qy\base\MPNewsArticle[] $value
     * @return $this
     */
    public function setArticles($value)
    {
        return $this->setMsgType(Message::TYPE_MPNEWS)
                    ->setData('mpnews', static::buildArticles($value));
    }

    /**
     * @param \cdcchen\wechat\qy\base\MPNewsArticle[] $articles
     * @return array
     */
    private static function buildArticles(array $articles)
    {
        $items = [];
        foreach ($articles as $article) {
            $items[] = $article->toArray();
        }

        return ['articles' => $items];
    }
}