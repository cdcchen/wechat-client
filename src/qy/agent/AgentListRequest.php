<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 22:53
 */

namespace cdcchen\wechat\qy\agent;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class AgentListRequest
 * @package cdcchen\wechat\qy\agent
 */
class AgentListRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/agent/list';
}