<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:26
 */

namespace cdcchen\wechat\qy\base;


/**
 * Class MPNewsArticle
 * @package cdcchen\wechat\qy\models
 */
class MPNewsArticle extends BaseModel
{
    /**
     * @param $text
     * @return $this
     */
    public function setTitle($text)
    {
        return $this->setAttribute('title', $text);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setAuthor($name)
    {
        return $this->setAttribute('author', $name);
    }

    /**
     * @param $text
     * @return $this
     */
    public function setContent($text)
    {
        return $this->setAttribute('content', $text);
    }

    /**
     * @param $text
     * @return $this
     */
    public function setDigest($text)
    {
        return $this->setAttribute('digest', $text);
    }

    /**
     * @param $media_id
     * @return $this
     */
    public function setThumbMediaId($media_id)
    {
        return $this->setAttribute('thumb_media_id', $media_id);
    }

    /**
     * @param $url
     * @return $this
     */
    public function setContentSourceUrl($url)
    {
        return $this->setAttribute('content_source_url', $url);
    }

    /**
     * @param $flag
     * @return $this
     */
    public function setShowCoverPic($flag)
    {
        return $this->setAttribute('show_cover_pic', $flag ? 1 : 0);
    }


    /**
     * @return array
     */
    public function fields()
    {
        return [
            'title',
            'author',
            'content',
            'digest',
            'thumb_media_id',
            'content_source_url',
            'show_cover_pic',
        ];
    }
}