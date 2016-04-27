<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:29
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\qy\base\BaseModel;

class User extends BaseModel
{
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;

    const STATUS_FOLLOWED     = 1;
    const STATUS_FORBIDDEN    = 2;
    const STATUS_NOT_FOLLOWED = 4;

    public function setUserId($id)
    {
        return $this->setAttribute('userid', $id);
    }

    public function setName($value)
    {
        return $this->setAttribute('name', $value);
    }

    public function setDepartment($value)
    {
        return $this->setAttribute('department', $value);
    }

    public function setPosition($value)
    {
        return $this->setAttribute('position', $value);
    }

    public function setGender($value)
    {
        return $this->setAttribute('gender', $value);
    }

    public function setMobile($value)
    {
        return $this->setAttribute('mobile', $value);
    }

    public function setEmail($value)
    {
        return $this->setAttribute('email', $value);
    }

    public function setWeixinId($value)
    {
        return $this->setAttribute('weixinid', $value);
    }

    public function setEnable($value)
    {
        return $this->setAttribute('enable', (int)(bool)$value);
    }

    public function setAvatarMediaId($value)
    {
        return $this->setAttribute('avatar_mediaid', $value);
    }

    public function setExtAttr($value)
    {
        return $this->setAttribute('extattr', $value);
    }

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