<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 22:51
 */

namespace cdcchen\wechat\qy\agent;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class AgentInfoRequest
 * @package cdcchen\wechat\qy\agent
 */
class AgentInfoRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/agent/get';

    /**
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setQueryParam('agentid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid'];
    }
}