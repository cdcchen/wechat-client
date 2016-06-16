<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 00:20
 */

namespace cdcchen\wechat\qy\chat;


/**
 * Class ChatSendVoiceRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatSendVoiceRequest extends ChatSendMessageRequest
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setData('msgtype', ChatMessage::MSG_TYPE_VOICE);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMediaId($value)
    {
        return $this->setData('voice', ['media_id' => $value]);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        $params = parent::getRequireParams();
        $params[] = 'voice';
        return $params;
    }
}