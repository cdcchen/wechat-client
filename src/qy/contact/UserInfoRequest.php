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
 * Class UserInfoRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserInfoRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/get';

    /**
     * @param string $value
     * @return $this
     */
    public function setUserId($value)
    {
        return $this->setQueryParam('userid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['userid'];
    }
}