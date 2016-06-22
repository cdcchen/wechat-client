<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 17:20
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class Message
 * @package cdcchen\wechat\qy\chat\push\models
 */
class Message extends BaseItem
{
    /**
     * @return string
     */
    public function getMsgId()
    {
        return $this->get('MsgId');
    }

    /**
     * @return string
     */
    public function getReceiverType()
    {
        return $this->getReceiver('Type');
    }

    /**
     * @return string
     */
    public function getReceiverId()
    {
        return $this->getReceiver('Id');
    }

    /**
     * @param null|string $name
     * @return string
     */
    private function getReceiver($name = null)
    {
        $receiver = $this->get('Receiver');
        return $name === null ? $receiver : (isset($receiver[$name]) ? $receiver[$name] : null);
    }
}