<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 23:19
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ChatClearNotifyRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatClearNotifyRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/clearnotify';

    /**
     * @param $value
     * @return $this
     */
    public function setOperateUser($value)
    {
        return $this->setData('op_user', $value);
    }

    /**
     * @param $type
     * @param $id
     * @return $this
     */
    public function setChat($type, $id)
    {
        return $this->setData('chat', ['type' => $type, 'id' => $id]);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['op_user', 'chat'];
    }
}