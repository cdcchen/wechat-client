<?php
namespace cdcchen\wechat\auth;


/**
 * Class ShaHmac1Signer
 * @package cdcchen\aliyun\core\auth
 */
class ShaHmac1Signer implements SignerInterface
{
    /**
     * @param string $source
     * @param string $accessSecret
     * @return string
     */
    public function buildSignature($source, $accessSecret)
    {
        return base64_encode(hash_hmac('sha1', $source, $accessSecret, true));
    }

    /**
     * @return string
     */
    public function getSignatureMethod()
    {
        return 'HMAC-SHA1';
    }

    /**
     * @return string
     */
    public function getSignatureVersion()
    {
        return '1.0';
    }

}