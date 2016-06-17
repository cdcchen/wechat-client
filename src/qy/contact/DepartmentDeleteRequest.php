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
 * Class DepartmentDeleteRequest
 * @package cdcchen\wechat\qy\contact
 */
class DepartmentDeleteRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/department/delete';


    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setQueryParam('id', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['id'];
    }
}