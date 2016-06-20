<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 10:36
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class CorpTokenRequest
 * @package cdcchen\wechat\qy\suite
 */
class CorpTokenRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/service/get_corp_token';

    /**
     * @param string $id
     * @return $this
     */
    public function setSuiteId($id)
    {
        return $this->setData('suite_id', $id);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAuthCorpId($value)
    {
        return $this->setData('auth_corpid', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPermanentCode($value)
    {
        return $this->setData('permanent_code', $value);
    }
}