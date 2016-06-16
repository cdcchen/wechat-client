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
 * Class ChatCreateRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatCreateRequest extends BaseRequest
{
    /**
     * Min users count
     */
    const USERS_MIN_COUNT = 3;
    /**
     * Max user count
     */
    const USERS_MAX_COUNT = 1000;

    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/create';

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
    public function setUsers($value)
    {
        return $this->setData('userlist', (array)$value);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['chatid', 'name', 'owner', 'userlist'];
    }

    public function prepare()
    {
        $owner = $this->getData('owner');
        $users = $this->getData('userlist');
        $this->checkParams($owner, $users);
    }

    /**
     * @param string $owner
     * @param array $users
     * @return bool
     */
    protected static function checkParams($owner, $users)
    {
        $count = count($users);
        if ($count < self::USERS_MIN_COUNT || $count > self::USERS_MAX_COUNT) {
            throw new \InvalidArgumentException(sprintf('Users count must be between %d and %d.',
                self::USERS_MIN_COUNT, self::USERS_MAX_COUNT));
        } elseif (!in_array($owner, $users)) {
            throw new \InvalidArgumentException('Owner must be included in the users.');
        } else {
            return true;
        }
    }
}