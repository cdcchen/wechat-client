<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:26
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\qy\base\BaseModel;

class ChatGroup extends BaseModel
{
    public $chatId;
    public $name;
    public $owner;
    public $userList = [];

    public function setChatId($id)
    {
        return $this->setAttribute('chatid', $id);
    }

    public function setName($name)
    {
        $this->setAttribute('name', $name);
    }

    public function setOwner($owner)
    {
        $this->setAttribute('owner', $owner);
    }

    public function setUserList($userList)
    {
        $this->setAttribute('userList', $userList);
    }

    protected function fields()
    {
        return ['chatid', 'name', 'owner', 'userlist'];
    }
}