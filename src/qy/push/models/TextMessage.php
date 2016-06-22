<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:29
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class Text
 * @package cdcchen\wechat\qy\push\models
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