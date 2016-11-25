<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 22:51
 */

namespace cdcchen\wechat\qy\agent;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class AgentUpdateRequest
 * @package cdcchen\wechat\qy\agent
 */
class AgentUpdateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/agent/set';

    /**
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('agentid', $value);
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
     * @param int $value
     * @return $this
     */
    public function setReportLocationFlag($value)
    {
        return $this->setData('report_location_flag', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLogoMediaId($value)
    {
        return $this->setData('logo_mediaid', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDescription($value)
    {
        return $this->setData('description', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setRedirectDomain($value)
    {
        return $this->setData('redirect_domain', $value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsReportEnter($value = true)
    {
        return $this->setData('isreportenter', (int)(bool)$value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsReportUser($value = true)
    {
        return $this->setData('isreportuser', (int)(bool)$value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setHomeUrl($value)
    {
        return $this->setData('home_url', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setExtensionUrl($value)
    {
        return $this->setData('chat_extension_url', $value);
    }


    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid'];
    }
}