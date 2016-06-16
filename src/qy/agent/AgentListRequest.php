<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 22:53
 */

namespace cdcchen\wechat\qy\agent;


use cdcchen\wechat\base\BaseRequest;

class AgentListRequest extends BaseRequest
{
    protected $method = 'get';
    protected $action = '/cgi-bin/agent/list';
}