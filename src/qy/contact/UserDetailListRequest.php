<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 11:14
 */

namespace cdcchen\wechat\qy\contact;


/**
 * Class UserDetailListRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserDetailListRequest extends UserSimpleListRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/list';

    /**
     * @param string $value
     * @return $this
     */
    public function setDepartmentId($value)
    {
        return $this->setQueryParam('department_id', $value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setFetchChild($value)
    {
        return $this->setQueryParam('fetch_child', (int)(bool)$value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setStatus($value)
    {
        return $this->setQueryParam('status', (int)$value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['department_id'];
    }

}