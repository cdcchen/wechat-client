<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 10:27
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class PreAuthCodeRequest
 * @package cdcchen\wechat\qy\suite
 */
class PreAuthCodeRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgin-bin/service/get_pre_auth_code';

    /**
     * @param string $id
     * @return $this
     */
    public function setSuiteId($id)
    {
        return $this->setData('suite_id', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['suite_id'];
    }
}