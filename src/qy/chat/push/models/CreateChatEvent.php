<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 17:22
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class CreateChatEvent
 * @package cdcchen\wechat\qy\chat\push\models
 */
class CreateChatEvent extends Event
{
    /**
     * @param null|string $name
     * @return mixed|null
     */
    public function getChatInfo($name = null)
    {
        $info = $this->get('ChatInfo');

        return $name === null ? $info : (isset($info[$name]) ? $info[$name] : null);
    }

    /**
     * @return string|null
     */
    public function getChatId()
    {
        return $this->getChatInfo('ChatId');
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getChatInfo('Name');
    }

    /**
     * @return string|null
     */
    public function getOwner()
    {
        return $this->getChatInfo('Owner');
    }

    /**
     * @return array
     */
    public function getUserList()
    {
        $users = $this->getChatInfo('UserList');
        return empty($users) ? [] : explode('|', $users);
    }
}