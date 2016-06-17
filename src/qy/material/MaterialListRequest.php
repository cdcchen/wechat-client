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
 * Class MaterialListRequest
 * @package cdcchen\wechat\qy\material
 */
class MaterialListRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/material/batchget';

    /**
     * @param int $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setData('agentid', $id);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setType($value)
    {
        return $this->setData('type', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setOffset($value)
    {
        return $this->setData('offset', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setCount($value)
    {
        return $this->setData('count', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid', 'media_id', 'offset', 'count'];
    }
}