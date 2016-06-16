<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 23:17
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ChatInfoRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatInfoRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/get';

    /**
     * @param string $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setQueryParam('chatid', $value);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['chatid'];
    }
}