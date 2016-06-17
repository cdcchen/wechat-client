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
 * Class MaterialDeleteRequest
 * @package cdcchen\wechat\qy\material
 */
class MaterialDeleteRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/material/del';

    /**
     * @param int $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setQueryParam('agentid', $id);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setMediaId($id)
    {
        return $this->setQueryParam('media_id', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid', 'media_id'];
    }
}