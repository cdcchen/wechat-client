<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:13
 */

namespace cdcchen\wechat\qy\message;


use cdcchen\wechat\qy\material\NewsArticle;

/**
 * Class NewsMessageSendRequest
 * @package cdcchen\wechat\qy\message
 */
class NewsMessageSendRequest extends MessageSendRequest
{
    /**
     * @var string
     */
    protected $msgType = Message::TYPE_NEWS;

    /**
     * @param NewsArticle[] $value
     * @return $this
     */
    public function setArticles($value)
    {
        return $this->setData('news', static::buildArticles($value));
    }

    /**
     * @param NewsArticle[] $articles
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