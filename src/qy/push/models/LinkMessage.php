<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:37
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class LinkMessage
 * @package cdcchen\wechat\qy\push\models
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
    public function getPicUrl()
    {
        return $this->get('PicUrl');
    }
}