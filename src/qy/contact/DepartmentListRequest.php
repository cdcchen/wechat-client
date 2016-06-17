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
 * Class DepartmentListRequest
 * @package cdcchen\wechat\qy\contact
 */
class DepartmentListRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/department/list';


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