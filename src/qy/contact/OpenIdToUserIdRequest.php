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
 * Class OpenIdToUserIdRequest
 * @package cdcchen\wechat\qy\contact
 */
class OpenIdToUserIdRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/convert_to_userid';

    /**
     * @param string $value
     * @return $this
     */
    public function setOpenId($value)
    {
        return $this->setData('openid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['openid'];
    }
}