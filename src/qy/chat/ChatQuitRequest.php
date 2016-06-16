<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ChatQuitRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatQuitRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/quit';

    /**
     * @param string $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('chatid', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOperateUser($value)
    {
        return $this->setData('op_user', $value);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['chatid', 'op_user'];
    }

}