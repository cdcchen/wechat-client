<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/27
 * Time: 10:41
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\qy\base\BaseModel;

/**
 * Class ChatMessage
 * @package cdcchen\wechat\qy\chat
 */
class ChatMessage extends BaseModel
{
    /**
     * Text msg type
     */
    const MSG_TYPE_TEXT = 'text';
    /**
     * Image msg type
     */
    const MSG_TYPE_IMAGE = 'image';
    /**
     * File msg type
     */
    const MSG_TYPE_FILE = 'file';
    /**
     * Voice msg type
     */
    const MSG_TYPE_VOICE = 'voice';

    /**
     * @param int $type
     * @return $this
     */
    public function setReceiverType($type)
    {
        return $this->setAttribute('receiver.type', $type);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setReceiverId($id)
    {
        return $this->setAttribute('receiver.id', $id);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSender($value)
    {
        return $this->setAttribute('sender', $value);
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setMsgType($type)
    {
        $types = [self::MSG_TYPE_TEXT, self::MSG_TYPE_IMAGE, self::MSG_TYPE_FILE, self::MSG_TYPE_VOICE];
        if (in_array($type, $types)) {
            return $this->setAttribute('msgtype', $type);
        }

        throw new \InvalidArgumentException("$type is not a valid type.");
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Exception
     */
    public function setContent($value)
    {
        $msgType = $this->getAttribute('msgtype');
        if (empty($msgType)) {
            throw new \Exception('Attribute msgtype is required.');
        }

        if ($msgType === self::MSG_TYPE_TEXT) {
            $content = ['content' => $value];
        } else {
            $content = ['media_id' => $value];
        }

        return $this->setAttribute($msgType, $content);
    }

    /**
     * @return array
     */
    protected function fields()
    {
        return ['receiver', 'sender', 'msgtype', 'text', 'file', 'image', 'voice'];
    }
}