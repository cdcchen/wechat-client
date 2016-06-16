<?php
namespace cdcchen\wechat\auth;


/**
 * Interface SignerInterface
 * @package cdcchen\aliyun\core\auth
 */
interface SignerInterface
{
    /**
     * Signature method HMAC-SHA1
     */
    const HMAC_SHA1 = 'HMAC-SHA1';
    /**
     * Signature method HMAC-SHA1
     */
    const HMAC_SHA256 = 'HMAC-SHA256';

    /**
     * @return string
     */
    public function getSignatureMethod();

    /**
     * @return string
     */
    public function getSignatureVersion();

    /**
     * @param string $source
     * @param string $accessSecret
     * @return string
     */
    public function buildSignature($source, $accessSecret);
}