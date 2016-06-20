<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 10:34
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\wechat\base\BaseRequest;

class PermanentCodeRequest extends BaseRequest
{
    protected $method = 'post';
    protected $action = '/cgi-bin/service/get_permanent_code';

    public function setSuiteId($id)
    {
        return $this->setData('suite_id', $id);
    }

    public function setAuthCode($value)
    {
        return $this->setData('auth_code', $value);
    }
}