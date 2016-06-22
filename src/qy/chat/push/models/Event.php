<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 17:18
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class Event
 * @package cdcchen\wechat\qy\chat\push\models
 */
class Event extends BaseItem
{
    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->get('Event');
    }

    /**
     * @return bool
     */
    public function isCreateChatEvent()
    {
        return $this->getEvent() === self::EVENT_CREATE_CHAT;
    }

    /**
     * @return bool
     */
    public function isUpdateChatEvent()
    {
        return $this->getEvent() === self::EVENT_UPDATE_CHAT;
    }

    /**
     * @return bool
     */
    public function isQuitChatEvent()
    {
        return $this->getEvent() === self::EVENT_QUIT_CHAT;
    }
}