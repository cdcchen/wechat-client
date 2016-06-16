<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 00:20
 */

namespace cdcchen\wechat\qy\chat;


/**
 * Class ChatSendTextRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatSendTextRequest extends ChatSendMessageRequest
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setData('msgtype', ChatMessage::MSG_TYPE_TEXT);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setText($value)
    {
        return $this->setData('text', ['content' => $value]);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        $params = parent::getRequireParams();
        $params[] = 'text';
        return $params;
    }
}