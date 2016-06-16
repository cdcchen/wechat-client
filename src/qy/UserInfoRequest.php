<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 22:25
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class UserInfoRequest
 * @package cdcchen\wechat\qy
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
    protected $action = '/cgi-bin/user/getuserinfo';

    /**
     * @param string $value
     * @return $this
     */
    public function setCode($value)
    {
        return $this->setData('code', $value);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['code'];
    }
}