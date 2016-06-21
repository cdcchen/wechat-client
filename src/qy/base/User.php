<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:29
 */

namespace cdcchen\wechat\qy\base;


/**
 * Class User
 * @package cdcchen\wechat\qy\contact
 */
class User extends BaseModel
{
    /**
     * male
     */
    const GENDER_MALE = 1;
    /**
     * female
     */
    const GENDER_FEMALE = 2;

    /**
     * followed status
     */
    const STATUS_FOLLOWED = 1;
    /**
     * forbidden status
     */
    const STATUS_FORBIDDEN = 2;
    /**
     * not followed status
     */
    const STATUS_NOT_FOLLOWED = 4;

    /**
     * @param int $value
     * @return bool
     */
    public static function validateGender($value)
    {
        $genders = [self::GENDER_FEMALE, self::GENDER_MALE];
        return in_array($value, $genders);
    }

    /**
     * @param string $value
     * @return bool
     * @todo 功能未实现
     */
    public static function validateMobile($value)
    {
        return true;
    }

    public static function validateEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setUserId($id)
    {
        return $this->setAttribute('userid', $id);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setAttribute('name', $value);
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setDepartment($value)
    {
        return $this->setAttribute('department', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPosition($value)
    {
        return $this->setAttribute('position', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setGender($value)
    {
        return $this->setAttribute('gender', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMobile($value)
    {
        return $this->setAttribute('mobile', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setEmail($value)
    {
        return $this->setAttribute('email', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setWeixinId($value)
    {
        return $this->setAttribute('weixinid', $value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setEnable($value = true)
    {
        return $this->setAttribute('enable', (int)(bool)$value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAvatarMediaId($value)
    {
        return $this->setAttribute('avatar_mediaid', $value);
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setExtAttr($value)
    {
        return $this->setAttribute('extattr', $value);
    }

    /**
     * @return array
     */
    protected function fields()
    {
        return [
            'userid',
            'name',
            'department',
            'position',
            'mobile',
            'gender',
            'email',
            'weixinid',
            'avatar_mediaid',
            'enable',
            'extattr'
        ];
    }
}