<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 20:03
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\auth\QyCredential;
use cdcchen\wechat\base\BaseRequest;

/**
 * Class AccessTokenRequest
 * @package cdcchen\wechat\qy
 */
class AccessTokenRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/gettoken';

    /**
     * @param string $value
     * @return $this
     */
    public function setCorpId($value)
    {
        $this->setQueryParam('corpid', $value);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCorpSecret($value)
    {
        $this->setQueryParam('corpsecret', $value);
        return $this;
    }

    /**
     * @param QyCredential $credential
     * @return $this
     */
    public function setCredential(QyCredential $credential)
    {
        return $this->setCorpId($credential->getCorpId())
                    ->setCorpSecret($credential->getCorpSecret());
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['corpid', 'corpsecret'];
    }
}