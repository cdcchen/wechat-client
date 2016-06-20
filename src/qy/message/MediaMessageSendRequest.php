<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:13
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class MediaMessageSendRequest
 * @package cdcchen\wechat\qy\message
 */
class MediaMessageSendRequest extends MessageSendRequest
{
    /**
     * @param string $value
     * @return $this
     */
    public function setMediaId($value)
    {
        return $this->setData($this->msgType, ['media_id' => $value]);
    }
}