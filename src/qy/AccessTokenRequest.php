<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 20:03
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseRequest;

class AccessTokenRequest extends BaseRequest
{
    protected $method = 'get';
    protected $action = '/cgi-bin/gettoken';

    public function setCorpId($value)
    {
        $this->setQueryParam('corpid', $value);
        return $this;
    }

    public function setCorpSecret($value)
    {
        $this->setQueryParam('corpsecret', $value);
        return $this;
    }

    protected function getRequireParams()
    {
        return ['corpid', 'corpsecret'];
    }
}