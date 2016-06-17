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
 * Class DepartmentCreateRequest
 * @package cdcchen\wechat\qy\contact
 */
class DepartmentCreateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/department/create';

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
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['name', 'parentid'];
    }

    /**
     * @inheritdoc
     */
    protected function setDefaultParams()
    {
        $this->setParentId(1);
    }
}