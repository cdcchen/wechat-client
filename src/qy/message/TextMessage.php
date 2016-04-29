<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class TextMessage
 * @package cdcchen\wechat\qy\message
 */
class TextMessage extends Message
{
    /**
     * @inheritdoc
     */
    protected function init()
    {
        parent::init();
        $this->setMsgType(self::TYPE_TEXT);
    }

    /**
     * @param string $text
     * @return $this
     * @throws \Exception
     */
    public function setText($text)
    {
        return $this->setContent($text);
    }
}