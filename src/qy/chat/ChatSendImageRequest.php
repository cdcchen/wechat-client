<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 00:20
 */

namespace cdcchen\wechat\qy\chat;


/**
 * Class ChatSendImageRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatSendImageRequest extends ChatSendMessageRequest
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setData('msgtype', ChatMessage::MSG_TYPE_IMAGE);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMediaId($value)
    {
        return $this->setData('image', ['media_id' => $value]);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        $params = parent::getRequireParams();
        $params[] = 'image';
        return $params;
    }
}