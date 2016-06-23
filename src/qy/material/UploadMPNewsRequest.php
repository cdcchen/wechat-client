<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 15:12
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class UploadMPNewsRequest
 * @package cdcchen\wechat\qy\material
 */
class UploadMPNewsRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/material/add_mpnews';

    /**
     * @param int $agentId
     * @return $this
     */
    public function setAgentId($agentId)
    {
        return $this->setData('agentid', $agentId);
    }

    /**
     * @param \cdcchen\wechat\qy\base\MPNewsArticle[] $articles
     * @return $this
     */
    public function setArticles(array $articles)
    {
        $news = static::buildMArticles($articles);
        return $this->setData('mpnews', $news);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid', 'mpnews'];
    }

    /**
     * @param \cdcchen\wechat\qy\base\MPNewsArticle[] $articles
     * @return array
     */
    private static function buildMArticles(array $articles)
    {
        $data = [];
        foreach ($articles as $article) {
            $data[] = $article->toArray();
        }

        return ['articles' => $data];
    }

}