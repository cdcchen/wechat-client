<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:58
 */

namespace cdcchen\wechat\qy\push;


use cdcchen\wechat\auth\CallbackCredential;
use cdcchen\wechat\base\Object;
use cdcchen\wechat\qy\base\NewsArticle;
use cdcchen\wechat\security\PrpCrypt;

/**
 * Class MessageResponse
 * @package cdcchen\wechat\qy\push
 */
class MessageResponse extends Object
{
    /**
     * type text
     */
    const TYPE_TEXT = 'text';
    /**
     * type image
     */
    const TYPE_IMAGE = 'image';
    /**
     * type voice
     */
    const TYPE_VOICE = 'voice';
    /**
     * type video
     */
    const TYPE_VIDEO = 'video';
    /**
     * type news
     */
    const TYPE_NEWS = 'news';

    /**
     * @var string
     */
    private $_token;
    /**
     * @var string
     */
    private $_encodingAesKey;
    /**
     * @var string
     */
    private $_corpId;

    /**
     * @var string
     */
    private $_toUser;
    /**
     * @var string
     */
    private $_fromUser;
    /**
     * @var string
     */
    private $_msgType;

    /**
     * MessageResponse constructor.
     * @param string $corpId
     * @param string $token
     * @param string $encodingAesKey
     */
    public function __construct($corpId, $token, $encodingAesKey)
    {
        $this->_token = $token;
        $this->_encodingAesKey = $encodingAesKey;
        $this->_corpId = $corpId;
    }

    /**
     * @param string $text
     * @return string
     */
    public function text($text)
    {
        $this->_msgType = self::TYPE_TEXT;

        $format = '<Content><![CDATA[%s]]></Content>';
        $extraXml = sprintf($format, $text);

        return $this->buildContentXml($extraXml);
    }

    /**
     * @param string $mediaId
     * @return string
     */
    public function image($mediaId)
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<Image><MediaId><![CDATA[%s]]></MediaId></Image>';
        $extraXml = sprintf($format, $mediaId);

        return $this->buildContentXml($extraXml);
    }

    /**
     * @param string $mediaId
     * @return string
     */
    public function voice($mediaId)
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<Voice><MediaId><![CDATA[%s]]></MediaId></Voice>';
        $extraXml = sprintf($format, $mediaId);

        return $this->buildContentXml($extraXml);
    }

    /**
     * @param string $mediaId
     * @param string $title
     * @param string $desc
     * @return string
     */
    public function video($mediaId, $title = '', $desc = '')
    {
        $this->_msgType = self::TYPE_IMAGE;

        $format = '<Video>
            <MediaId><![CDATA[%s]]></MediaId>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
        </Video>';
        $extraXml = sprintf($format, $mediaId, $title, $desc);

        return $this->buildContentXml($extraXml);
    }

    /**
     * @param \cdcchen\wechat\qy\base\NewsArticle[] $items
     * @return string
     */
    public function news(array $items)
    {
        $this->_msgType = self::TYPE_IMAGE;
        $articles = '';
        foreach ($items as $item) {
            $articles .= static::buildNewsItem($item);
        }

        $format = '<ArticleCount>%d</ArticleCount><Articles>%s</Articles>';
        $extraXml = sprintf($format, count($items), $articles);

        return $this->buildContentXml($extraXml);
    }

    /**
     * @param NewsArticle $article
     * @return string
     */
    public static function buildNewsItem(NewsArticle $article)
    {
        $format = '<Item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </Item>';

        return sprintf($format, $article->getTitle(), $article->getDescription(), $article->getPicUrl(),
            $article->getUrl());
    }

    /**
     * @param string $toUser
     * @return $this
     */
    public function setToUser($toUser)
    {
        $this->_toUser = $toUser;
        return $this;
    }

    /**
     * @param string $fromUser
     * @return $this
     */
    public function setFromUser($fromUser)
    {
        $this->_fromUser = $fromUser;
        return $this;
    }


    /**
     * @param string $extraXml
     * @return string
     */
    protected function buildContentXml($extraXml)
    {
        $format = '<xml>
           <Encrypt><![CDATA[%s]]></Encrypt>
           <MsgSignature><![CDATA[%s]]></MsgSignature>
           <TimeStamp>%s</TimeStamp>
           <Nonce><![CDATA[%s]]></Nonce>
        </xml>';

        $timestamp = time();
        $nonce = uniqid();
        $plainXml = $this->buildPlainXml($extraXml);
        $encryptXml = $this->buildEncryptedXml($plainXml);
        $signature = CallbackCredential::getSHA1($this->_token, $timestamp, $nonce, $encryptXml);

        return sprintf($format, $encryptXml, $signature, $timestamp, $nonce);
    }

    /**
     * @param string $xml
     * @return string
     */
    protected function buildEncryptedXml($xml)
    {
        $crypt = new PrpCrypt($this->_encodingAesKey);
        return $crypt->encrypt($xml, $this->_corpId);
    }

    /**
     * @param string $extraXml
     * @return string
     */
    protected function buildPlainXml($extraXml)
    {
        return '<xml>' . $this->defaultPlainXml() . $extraXml . '</xml>';
    }

    /**
     * @return string
     */
    protected function defaultPlainXml()
    {
        if (empty($this->_toUser) || empty($this->_fromUser) || empty($this->_msgType)) {
            throw new \InvalidArgumentException('ToUserName|FromUserName|MsgType is required.');
        }

        $format = '<ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%d</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>';

        return sprintf($format, $this->_toUser, $this->_fromUser, time(), $this->_msgType);
    }
}