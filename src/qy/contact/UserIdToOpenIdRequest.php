<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 11:14
 */

namespace cdcchen\wechat\qy\contact;

use cdcchen\wechat\base\BaseRequest;


/**
 * Class UserIdToOpenIdRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserIdToOpenIdRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/convert_to_openid';

    /**
     * @param string $value
     * @return $this
     */
    public function setUserId($value)
    {
        return $this->setData('userid', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setAgentId($value)
    {
        return $this->setData('agentid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['userid'];
    }
}