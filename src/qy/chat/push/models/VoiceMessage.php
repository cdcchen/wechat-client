<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 19:09
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class VoiceMessage
 * @package cdcchen\wechat\qy\chat\push\models
 */
class VoiceMessage extends Message
{
    /**
     * @return string
     */
    public function getMediaId()
    {
        return $this->get('MediaId');
    }
}