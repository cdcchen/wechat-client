<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:26
 */

namespace cdcchen\wechat\qy\base;


/**
 * Class NewsArticle
 * @package cdcchen\wechat\qy\models
 */
class NewsArticle extends BaseModel
{
    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setAttribute('title', $title);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setAttribute('description', $description);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setAttribute('url', $url);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setPicUrl($url)
    {
        return $this->setAttribute('picurl', $url);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getAttribute('description');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getAttribute('url');
    }

    /**
     * @return string
     */
    public function getPicUrl()
    {
        return $this->getAttribute('picurl');
    }


    /**
     * @return array
     */
    public function fields()
    {
        return ['title', 'description', 'url', 'picurl'];
    }
}