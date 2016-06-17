<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 17:31
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class DepartmentUpdateRequest
 * @package cdcchen\wechat\qy\contact
 */
class DepartmentUpdateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/department/update';


    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setData('name', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setParentId($value)
    {
        return $this->setData('parentid', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setOrder($value)
    {
        return $this->setData('order', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['id'];
    }
}