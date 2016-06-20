<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 10:34
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class PermanentCodeRequest
 * @package cdcchen\wechat\qy\suite
 */
class PermanentCodeRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/service/get_permanent_code';

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
    public function setAuthCode($value)
    {
        return $this->setData('auth_code', $value);
    }
}