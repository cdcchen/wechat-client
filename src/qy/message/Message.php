<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:17
 */

namespace cdcchen\wechat\qy\message;


use cdcchen\wechat\qy\base\BaseModel;

/**
 * Class Message
 * @package cdcchen\wechat\qy\message
 */
class Message extends BaseModel
{
    /**
     * Max user count
     */
    const MAX_USER_COUNT = 1000;
    /**
     * Max party count
     */
    const MAX_PARTY_COUNT = 100;

    /**
     * Text message type
     */
    const TYPE_TEXT = 'text';
    /**
     * Image message type
     */
    const TYPE_IMAGE = 'image';
    /**
     * Voice message type
     */
    const TYPE_VOICE = 'voice';
    /**
     * Video message type
     */
    const TYPE_VIDEO = 'video';
    /**
     * File message type
     */
    const TYPE_FILE = 'file';
    /**
     * News message type
     */
    const TYPE_NEWS = 'news';
    /**
     * MPNews message type
     */
    const TYPE_MPNEWS = 'mpnews';

    /**
     *  enable encrypt message
     */
    const SAFE_YES = 1;
    /**
     * disable encrypt message
     */
    const SAFE_NO = 0;

    /**
     * All User flag
     */
    const ALL_USER_FLAG = '@all';

    /**
     * @param int $type
     * @return $this
     */
    public static function validateMsgType($type)
    {
        $types = [
            self::TYPE_TEXT,
            self::TYPE_IMAGE,
            self::TYPE_VOICE,
            self::TYPE_VIDEO,
            self::TYPE_FILE,
            self::TYPE_NEWS,
            self::TYPE_MPNEWS
        ];

        return in_array($type, $types);
    }


    protected function fields()
    {
    }
}