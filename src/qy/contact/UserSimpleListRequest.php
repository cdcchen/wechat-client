<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 11:14
 */

namespace cdcchen\wechat\qy\contact;

use cdcchen\wechat\base\BaseRequest;


/**
 * Class UserSimpleListRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserSimpleListRequest extends BaseRequest
{
    /**
     * All status
     */
    const STATUS_ALL = 0;

    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/simplelist';

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
        return $this->setQueryParam('fetch_child', (int)$value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['department_id'];
    }

}