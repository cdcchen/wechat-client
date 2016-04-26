<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午5:11
 */
namespace cdcchen\wechat\security;

/**
 * PrpCrypt class
 *
 * 提供接收和推送给公众平台消息的加解密接口.
 */
class PrpCrypt
{
    const RANDOM_STRING_LEN = 16;
    const INIT_VECTOR_SIZE  = 16;

    private $_key;

    public function __construct($k)
    {
        $this->_key = base64_decode($k . '=');
    }

    /**
     * 对明文进行加密
     * @param string $text 需要加密的明文
     * @param string $corp_id
     * @return string 加密后的密文
     */
    public function encrypt($text, $corp_id)
    {

        try {
            //获得16位随机字符串，填充到明文之前
            $random = $this->getRandomStr();
            $text = $random . pack('N', strlen($text)) . $text . $corp_id;

            //使用自定义的填充方式对明文进行补位填充
            $text = PKCS7Encoder::encode($text);
            $iv = substr($this->_key, 0, self::INIT_VECTOR_SIZE);
            $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_key, $text, MCRYPT_MODE_CBC, $iv);

            return base64_encode($encrypted);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 对密文进行解密
     * @param string $encrypted 需要解密的密文
     * @param string $corp_id
     * @return string 解密得到的明文
     */
    public function decrypt($encrypted, $corp_id)
    {

        try {
            //使用BASE64对需要解密的字符串进行解码
            $cipherText = base64_decode($encrypted);
            $iv = substr($this->_key, 0, self::INIT_VECTOR_SIZE);
            $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_key, $cipherText, MCRYPT_MODE_CBC, $iv);
        } catch (\Exception $e) {
            return false;
        }

        try {
            //去除补位字符
            $result = PKCS7Encoder::decode($decrypted);

            //去除16位随机字符串,网络字节序和AppId
            if (strlen($result) < self::RANDOM_STRING_LEN) {
                return '';
            }

            $content = substr($result, self::RANDOM_STRING_LEN);
            list(, $xmlContentLen) = unpack('N', substr($content, 0, 4));
            $xmlContent = substr($content, 4, $xmlContentLen);
            $fromCorpID = substr($content, $xmlContentLen + 4);
        } catch (\Exception $e) {
            return false;
        }

        if ($fromCorpID != $corp_id) {
            return false;
        }

        return $xmlContent;
    }


    /**
     * 随机生成16位字符串
     * @return string 生成的字符串
     */
    public function getRandomStr()
    {
        $str = '';
        $strPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($strPool) - 1;
        for ($i = 0; $i < self::RANDOM_STRING_LEN; $i++) {
            $str .= $strPool[mt_rand(0, $max)];
        }

        return $str;
    }
}