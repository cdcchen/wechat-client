<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\message;


class TextMessage extends Message
{
    protected function init()
    {
        parent::init();
        $this->setMsgType(self::TYPE_TEXT);
    }

    public function setText($text)
    {
        return $this->setContent($text);
    }
}