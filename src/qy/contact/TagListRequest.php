<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 10:50
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\base\BaseRequest;

class TagListRequest extends BaseRequest
{
    protected $method = 'get';
    protected $action = '/cgi-bin/tag/list';
}