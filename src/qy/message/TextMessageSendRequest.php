<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/18
 * Time: 08:13
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class TextMessageSendRequest
 * @package cdcchen\wechat\qy\message
 */
class TextMessageSendRequest extends MessageSendRequest
{
    /**
     * @param string $value
     * @return $this
     */
    public function setText($value)
    {
        return $this->setMsgType(Message::TYPE_TEXT)
                    ->setData('text', ['content' => $value]);
    }
}