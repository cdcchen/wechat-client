<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:13
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class VideoMessageSendRequest
 * @package cdcchen\wechat\qy\message
 */
class VideoMessageSendRequest extends MediaMessageSendRequest
{
    /**
     * @var string
     */
    protected $msgType = Message::TYPE_VIDEO;
}