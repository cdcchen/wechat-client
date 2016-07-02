<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/7/2
 * Time: 17:01
 */

namespace cdcchen\wechat\qy\jsapi;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class JsApiTicketRequest
 * @package cdcchen\wechat\qy\jsapi
 */
class JsApiTicketRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/get_jsapi_ticket';
}