<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:22
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class Message
 * @package cdcchen\wechat\qy\push\models
 */
class Message extends Base
{
    const TYPE_TEXT        = 'text';
    const TYPE_IMAGE       = 'image';
    const TYPE_VOICE       = 'voice';
    const TYPE_VIDEO       = 'video';
    const TYPE_SHORT_VIDEO = 'shortvideo';
    const TYPE_LOCATION    = 'location';
    const TYPE_EVENT       = 'event';
    const TYPE_LINK        = 'link';


    /**
     * @return string
     */
    public function getMsgId()
    {
        return $this->get('MsgId');
    }

    /**
     * @return bool
     */
    public function isTextMessage()
    {
        return $this->isMsgType(self::TYPE_TEXT);
    }

    /**
     * @return bool
     */
    public function isImageMessage()
    {
        return $this->isMsgType(self::TYPE_IMAGE);
    }

    /**
     * @return bool
     */
    public function isVoiceMessage()
    {
        return $this->isMsgType(self::TYPE_VOICE);
    }

    /**
     * @return bool
     */
    public function isVideoMessage()
    {
        return $this->isMsgType(self::TYPE_VIDEO);
    }

    /**
     * @return bool
     */
    public function isShortVideoMessage()
    {
        return $this->isMsgType(self::TYPE_SHORT_VIDEO);
    }

    /**
     * @return bool
     */
    public function isLocationMessage()
    {
        return $this->isMsgType(self::TYPE_LOCATION);
    }

    /**
     * @return bool
     */
    public function isLinkMessage()
    {
        return $this->isMsgType(self::TYPE_LINK);
    }

    /**
     * @return bool
     */
    public function isEventMessage()
    {
        return $this->isMsgType(self::TYPE_EVENT);
    }

    /**
     * @param string $type
     * @return bool
     */
    private function isMsgType($type)
    {
        return $this->getMsgType() === $type;
    }
}