<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 23:17
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ChatUpdateRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatUpdateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/update';

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
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setData('name', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOwner($value)
    {
        return $this->setData('owner', $value);
    }

    /**
     * @param string|array $value
     * @return $this
     */
    public function setAddUsers($value)
    {
        return $this->setData('add_user_list', (array)$value);
    }

    /**
     * @param string|array $value
     * @return $this
     */
    public function setDeleteUsers($value)
    {
        return $this->setData('del_user_list', (array)$value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['chatid', 'op_user'];
    }

}