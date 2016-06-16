<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/27
 * Time: 下午4:32
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ServerClient
 * @package cdcchen\wechat\qy
 */
class CallbackServerIPRequest extends BaseRequest
{
    protected $method = 'get';
    protected $action = '/cgi-bin/getcallbackip';
}