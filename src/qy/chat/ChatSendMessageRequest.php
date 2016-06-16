<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 23:20
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ChatSendMessageRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatSendMessageRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/send';

    /**
     * @param string $type
     * @param string $id
     * @return $this
     */
    public function setReceiver($type, $id)
    {
        return $this->setData('receiver', ['type' => $type, 'id' => $id]);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSender($value)
    {
        return $this->setData('sender', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMsgType($value)
    {
        return $this->setData('msgtype', $value);
    }

    /**
     * @param string $msgType
     * @param string|array $value
     * @return $this
     * @throws \Exception
     */
    public function setContent($msgType, $value)
    {
        if (empty($msgType)) {
            throw new \Exception('Attribute msgtype is required.');
        }

        if ($msgType === ChatMessage::MSG_TYPE_TEXT) {
            $content = ['content' => $value];
        } elseif ($msgType === ChatMessage::MSG_TYPE_LINK) {
            $content = $value;
        } else {
            $content = ['media_id' => $value];
        }

        return $this->setData($msgType, $content);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['msgtype', 'receiver', 'sender'];
    }
}