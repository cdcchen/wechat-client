<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 19:09
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class LinkMessage
 * @package cdcchen\wechat\qy\chat\push\models
 */
class LinkMessage extends Message
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->get('Title');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->get('Description');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->get('Url');
    }

    /**
     * @return string
     */
    public function getPicUrl()
    {
        return $this->get('PicUrl');
    }
}