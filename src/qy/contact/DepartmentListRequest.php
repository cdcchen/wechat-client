<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 17:31
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class DepartmentListRequest
 * @package cdcchen\wechat\qy
 */
class DepartmentListRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/department/list';


    /**
     * @param int $id
     */
    public function setDepartmentId($id)
    {
        $this->setQueryParam('id', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['id'];
    }
}