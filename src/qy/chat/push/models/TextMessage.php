<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 19:09
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class TextMessage
 * @package cdcchen\wechat\qy\chat\push\models
 */
class TextMessage extends Message
{
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->get('Content');
    }
}