<?php
namespace cdcchen\wechat\auth;


/**
 * Class Credential
 * @package cdcchen\wechat\auth
 */
class Credential
{
    /**
     * @var string Corp id
     */
    private $_corpId;
    /**
     * @var string Corp secret
     */
    private $_corpSecret;

    /**
     * Credential constructor.
     * @param string $corpId
     * @param string $corpSecret
     */
    function __construct($corpId, $corpSecret)
    {
        $this->setCorpId($corpId);
        $this->setCorpSecret($corpSecret);
    }

    /**
     * @return string
     */
    public function getCorpId()
    {
        return $this->_corpId;
    }

    /**
     * @param string $corpId
     */
    public function setCorpId($corpId)
    {
        $this->_corpId = $corpId;
    }

    /**
     * @return string
     */
    public function getCorpSecret()
    {
        return $this->_corpSecret;
    }

    /**
     * @param string $corpSecret
     */
    public function setCorpSecret($corpSecret)
    {
        $this->_corpSecret = $corpSecret;
    }
}