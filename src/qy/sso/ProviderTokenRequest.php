<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 20:03
 */

namespace cdcchen\wechat\qy\sso;


use cdcchen\wechat\auth\QyCredential;
use cdcchen\wechat\base\BaseRequest;

/**
 * Class ProviderTokenRequest
 * @package cdcchen\wechat\qy\login
 */
class ProviderTokenRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/service/get_provider_token';

    /**
     * @param string $value
     * @return $this
     */
    public function setCorpId($value)
    {
        $this->setData('corpid', $value);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setProviderSecret($value)
    {
        $this->setData('provider_secret', $value);
        return $this;
    }

    /**
     * @param QyCredential $credential
     * @return $this
     */
    public function setCredential(QyCredential $credential)
    {
        return $this->setCorpId($credential->getCorpId())
                    ->setProviderSecret($credential->getCorpSecret());
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['corpid', 'provider_secret'];
    }
}