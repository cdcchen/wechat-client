<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:26
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\qy\base\BaseModel;

/**
 * Class ChatGroup
 * @package cdcchen\wechat\qy\chat
 */
class ChatGroup extends BaseModel
{
    /**
     * @var string
     */
    public $chatId;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $owner;
    /**
     * @var array
     */
    public $userList = [];

    /**
     * @param string $id
     * @return $this
     */
    public function setChatId($id)
    {
        return $this->setAttribute('chatid', $id);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->setAttribute('name', $name);
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->setAttribute('owner', $owner);
    }

    /**
     * @param array $userList
     */
    public function setUserList($userList)
    {
        $this->setAttribute('userList', $userList);
    }

    /**
     * @return array
     */
    protected function fields()
    {
        return ['chatid', 'name', 'owner', 'userlist'];
    }
}