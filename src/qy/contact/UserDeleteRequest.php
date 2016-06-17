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
 * Class UserDeleteRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserDeleteRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/delete';

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