<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 11:14
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\base\BaseRequest;
use cdcchen\wechat\qy\base\User;

/**
 * Class UserCreateRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserCreateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/create';

    /**
     * @param string $value
     * @return $this
     */
    public function setUserId($value)
    {
        return $this->setData('userid', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setData('name', $value);
    }

    /**
     * @param string|array $value
     * @return $this
     */
    public function setDepartment($value)
    {
        $value = array_map('intval', (array)$value);
        return $this->setData('department', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPosition($value)
    {
        return $this->setData('position', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMobile($value)
    {
        if (!User::validateMobile($value)) {
            throw new \InvalidArgumentException("Mobile: $value is not a valid number.");
        }

        return $this->setData('mobile', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setGender($value)
    {
        if (!User::validateGender($value)) {
            throw new \InvalidArgumentException("Gender value: $value is not valid.");
        }

        return $this->setData('gender', (int)$value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setEmail($value)
    {
        if (!User::validateEmail($value)) {
            throw new \InvalidArgumentException("Email: $value is not a valid email.");
        }
        return $this->setData('email', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setWeixinId($value)
    {
        return $this->setData('weixinid', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAvatarMediaId($value)
    {
        return $this->setData('avatar_mediaid', $value);
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setExtraAttr(array $value)
    {
        $attributes = ['attrs' => $value];
        return $this->setData('extattr', $attributes);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['userid', 'name', 'department', 'mobile|weixinid|email'];
    }
}