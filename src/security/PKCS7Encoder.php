<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午4:32
 */

namespace cdcchen\wechat\security;


/**
 * PKCS7Encoder class
 *
 * 提供基于PKCS7算法的加解密接口.
 */
class PKCS7Encoder
{
    const BLOCK_SIZE = 32;

    /**
     * 对需要加密的明文进行填充补位
     *
     * @param string $text 需要进行填充补位操作的明文
     * @return string 补齐明文字符串
     */
    public static function encode($text)
    {
        $textLength = strlen($text);
        $padCount = self::BLOCK_SIZE - ($textLength % self::BLOCK_SIZE);

        $padChar = chr($padCount ?: $padCount + self::BLOCK_SIZE);

        return $text . str_repeat($padChar, $padCount);
    }

    /**
     * 对解密后的明文进行补位删除
     *
     * @param string $text 解密后的明文
     * @return string 删除填充补位后的明文
     */
    public static function decode($text)
    {
        $pad = ord(substr($text, -1));

        return ($pad < 1 || $pad > self::BLOCK_SIZE)
            ? $text
            : substr($text, 0, -$pad);
    }
}