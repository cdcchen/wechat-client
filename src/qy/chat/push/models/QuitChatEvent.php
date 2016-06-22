<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 17:22
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class QuitChatEvent
 * @package cdcchen\wechat\qy\chat\push\models
 */
class QuitChatEvent extends Event
{
    /**
     * @return string|null
     */
    public function getChatId()
    {
        return $this->get('ChatId');
    }
}