<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 17:22
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class UpdateChatEvent
 * @package cdcchen\wechat\qy\chat\push\models
 */
class UpdateChatEvent extends Event
{
    /**
     * @return string|null
     */
    public function getChatId()
    {
        return $this->get('ChatId');
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->get('Name');
    }

    /**
     * @return string|null
     */
    public function getOwner()
    {
        return $this->get('Owner');
    }

    /**
     * @return array
     */
    public function getAddUserList()
    {
        $users = $this->get('AddUserList');
        return empty($users) ? [] : explode('|', $users);
    }

    /**
     * @return array
     */
    public function getDelUserList()
    {
        $users = $this->get('DelUserList');
        return empty($users) ? [] : explode('|', $users);
    }
}