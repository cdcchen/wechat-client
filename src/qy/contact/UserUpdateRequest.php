<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 11:14
 */

namespace cdcchen\wechat\qy\contact;


/**
 * Class UserUpdateRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserUpdateRequest extends UserCreateRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/update';

    /**
     * @param bool $value
     * @return $this
     */
    public function setEnable($value = true)
    {
        return $this->setData('userid', (int)(bool)$value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['userid'];
    }
}