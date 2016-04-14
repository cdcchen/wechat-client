<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:58
 */

namespace weixin\qy\push;


use weixin\qy\Request;
use weixin\security\PrpCrypt;

class Response
{
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';

    private $_token;
    private $_encodingAesKey;
    private $_corpID;

    private $_toUser;
    private $_fromUser;
    private $_msgType;

    public function __construct($corp_id, $token, $encoding_aes_key)
    {
        $this->_token = $token;
        $this->_encodingAesKey = $encoding_aes_key;
        $this->_corpID = $corp_id;
    }

    public function text($text)
    {
        $this->_msgType = self::TYPE_TEXT;

        $format = '<Content><![CDATA[%s]]></Content>';
        $extraXml = sprintf($format, $text);

        return $this->buildContentXml($extraXml);
    }

    public function image($media_id)
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<Image><MediaId><![CDATA[%s]]></MediaId></Image>';
        $extraXml = sprintf($format, $media_id);

        return $this->buildContentXml($extraXml);
    }

    public function voice($media_id)
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<Voice><MediaId><![CDATA[%s]]></MediaId></Voice>';
        $extraXml = sprintf($format, $media_id);

        return $this->buildContentXml($extraXml);
    }

    public function video($media_id, $title = '', $desc = '')
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<Video>
            <MediaId><![CDATA[%s]]></MediaId>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
        </Video>';
        $extraXml = sprintf($format, $media_id, $title, $desc);

        return $this->buildContentXml($extraXml);
    }

    public function news(array $items)
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<ArticleCount>%d</ArticleCount><Articles>%s</Articles>';
        $extraXml = sprintf($format, count($items), join('', $items));

        return $this->buildContentXml($extraXml);
    }

    public static function buildNewsItem($title, $url, $desc, $pic_url)
    {
        $format = '<Item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </Item>';
        
        return sprintf($format, $title, $desc, $pic_url, $url);
    }

    public function setToUser($to_user)
    {
        $this->_toUser = $to_user;
        return $this;
    }

    public function setFromUser($from_user)
    {
        $this->_fromUser = $from_user;
        return $this;
    }



    protected function buildContentXml($extra_xml)
    {
        $format = '<xml>
           <Encrypt><![CDATA[%s]]></Encrypt>
           <MsgSignature><![CDATA[%s]]></MsgSignature>
           <TimeStamp>%s</TimeStamp>
           <Nonce><![CDATA[%s]]></Nonce>
        </xml>';

        $timestamp = time();
        $nonce = uniqid();
        $plainXml = $this->buildPlainXml($extra_xml);
        $encryptXml = $this->buildEncryptedXml($plainXml);
        $signature = Request::getSHA1($this->_token, $timestamp, $nonce, $encryptXml);

        return sprintf($format, $encryptXml, $signature, $timestamp, $nonce);
    }

    protected function buildEncryptedXml($xml)
    {
        $crypt = new PrpCrypt($this->_encodingAesKey);
        return $crypt->encrypt($xml, $this->_corpID);
    }

    protected function buildPlainXml($extra_xml)
    {
        return '<xml>' . $this->defaultPlainXml() . $extra_xml . '</xml>';
    }

    protected function defaultPlainXml()
    {
        if (empty($this->_toUser) || empty($this->_fromUser) || empty($this->_msgType))
            throw new \InvalidArgumentException('ToUserName|FromUserName|MsgType is required.');

        $format = '<ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%d</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>';

        return sprintf($format, $this->_toUser, $this->_fromUser, time(), $this->_msgType);
    }
}