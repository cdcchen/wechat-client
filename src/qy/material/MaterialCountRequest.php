<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 15:29
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class MaterialCountRequest
 * @package cdcchen\wechat\qy\material
 */
class MaterialCountRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/material/get_count';

    /**
     * @param int $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setQueryParam('agentid', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid'];
    }
}