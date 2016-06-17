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
 * Class UserBatchDeleteRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserBatchDeleteRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/batchdelete';

    /**
     * @param string|array $value
     * @return $this
     */
    public function setUsers($value)
    {
        return $this->setData('useridlist', (array)$value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['useridlist'];
    }
}