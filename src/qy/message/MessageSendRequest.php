<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:04
 */

namespace cdcchen\wechat\qy\message;


use cdcchen\wechat\base\BaseRequest;
use cdcchen\wechat\qy\base\Message;

/**
 * Class MessageSendRequest
 * @package cdcchen\wechat\qy\message
 */
class MessageSendRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/message/send';

    /**
     * @var string
     */
    protected $msgType;

    /**
     * @return $this
     */
    public function setToAllUsers()
    {
        return $this->setToUser('@all');
    }

    /**
     * @param string|array $value
     * @return $this
     */
    public function setToUser($value)
    {
        $users = is_array($value) ? join('|', $value) : $value;
        return $this->setData('touser', $users);
    }

    /**
     * @param string|array $value
     * @return $this
     */
    public function setToDepartment($value)
    {
        $departments = $tag = is_array($value) ? join('|', $value) : $value;
        return $this->setData('toparty', $departments);
    }

    /**
     * @param string|array $value
     * @return $this
     */
    public function setToTag($value)
    {
        $tags = is_array($value) ? join('|', $value) : $value;
        return $this->setData('totag', $tags);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMsgType($value)
    {
        $this->msgType = $value;
        return $this->setData('msgtype', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setAgentId($value)
    {
        return $this->setData('agentid', $value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsSafe($value)
    {
        return $this->setData('safe', (int)(bool)$value);
    }

    /**
     * @inheritdoc
     */
    protected function prepare()
    {
        if (empty($this->msgType)) {
            throw new \InvalidArgumentException('Please set msgtype param first.');
        }

        if (!Message::validateMsgType($this->msgType)) {
            throw new \InvalidArgumentException("{$this->msgType} is not a valid msg type.");
        }

        $this->setMsgType($this->msgType);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['touser|toparty|totag', 'msgtype', 'agentid', $this->msgType];
    }
}