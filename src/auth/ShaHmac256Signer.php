<?php
namespace cdcchen\wechat\auth;


/**
 * Class ShaHmac256Signer
 * @package cdcchen\aliyun\core\auth
 */
class ShaHmac256Signer implements SignerInterface
{
    /**
     * @param string $source
     * @param string $accessSecret
     * @return string
     */
    public function buildSignature($source, $accessSecret)
    {
        return base64_encode(hash_hmac('sha256', $source, $accessSecret, true));
    }

    /**
     * @return string
     */
    public function getSignatureMethod()
    {
        return 'HMAC-SHA256';
    }

    /**
     * @return string
     */
    public function getSignatureVersion()
    {
        return '1.0';
    }

}