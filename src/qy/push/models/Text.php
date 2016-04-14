<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:29
 */

namespace weixin\qy\push\models;


class Text extends Message
{
    public $content;

    protected function parseSpecificXml()
    {
        $this->content = (string)$this->_xml->Content;
    }
}