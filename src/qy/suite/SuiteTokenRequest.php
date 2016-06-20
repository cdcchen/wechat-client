<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:32
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class SuiteTokenRequest
 * @package cdcchen\wechat\qy\suit
 */
class SuiteTokenRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/service/get_suite_token';

    /**
     * @param string $id
     * @return $this
     */
    public function setSuitId($id)
    {
        return $this->setData('suite_id', $id);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setAuthCorpId($id)
    {
        return $this->setData('auth_corpid', $id);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setPermanentCode($id)
    {
        return $this->setData('permanent_code', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['suite_id', 'auth_corpid', 'permanent_code'];
    }
}