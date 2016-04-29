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
    const MAX_USER_COUNT  = 1000;
    /**
     * Max party count
     */
    const MAX_PARTY_COUNT = 100;

    /**
     * Text message type
     */
    const TYPE_TEXT   = 'text';
    /**
     * Image message type
     */
    const TYPE_IMAGE  = 'image';
    /**
     * Voice message type
     */
    const TYPE_VOICE  = 'voice';
    /**
     * Video message type
     */
    const TYPE_VIDEO  = 'video';
    /**
     * File message type
     */
    const TYPE_FILE   = 'file';
    /**
     * News message type
     */
    const TYPE_NEWS   = 'news';
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
     * @param int $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setAttribute('agentid', $id);
    }

    /**
     * @param string|array $values
     * @return $this
     */
    public function setToUser($values)
    {
        if ($values === self::ALL_USER_FLAG) {
            return $this->setToAllUser();
        }

        $values = (array)$values;
        if (count($values) > self::MAX_USER_COUNT) {
            throw new \InvalidArgumentException('The number of $to_user should not exceed ' . self::MAX_USER_COUNT);
        }


        return $this->setAttribute('touser', join('|', $values));
    }

    /**
     * @return $this
     */
    public function setToAllUser()
    {
        return $this->setAttribute('touser', self::ALL_USER_FLAG);
    }

    /**
     * @param string|array $values
     * @return $this
     */
    public function setToParty($values)
    {
        $values = (array)$values;
        if (count($values) > self::MAX_USER_COUNT) {
            throw new \InvalidArgumentException('The number of $to_user should not exceed ' . self::MAX_PARTY_COUNT);
        }

        return $this->setAttribute('toparty', join('|', $values));
    }

    /**
     * @param string|array $values
     * @return $this
     */
    public function setToTag($values)
    {
        return $this->setAttribute('totag', is_array($values) ? join('|', $values) : $values);
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setMsgType($type)
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
        if (in_array($type, $types)) {
            return $this->setAttribute('msgtype', $type);
        }

        throw new \InvalidArgumentException("$type is not a valid msg type.");
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setSafe($value)
    {
        return $this->setAttribute('safe', $value ? self::SAFE_YES : self::SAFE_NO);
    }

    /**
     * @param string|array $value
     * @return $this
     * @throws \Exception
     */
    protected function setContent($value)
    {
        $msgType = $this->getAttribute('msgtype');
        if (empty($msgType)) {
            throw new \Exception('msgtype is required.');
        }

        switch ($msgType) {
            case self::TYPE_TEXT:
                $content = ['content' => $value];
                break;
            case self::TYPE_NEWS:
                $content = ['articles' => $value];
                break;
            case self::TYPE_MPNEWS:
                $content = is_string($value) ? ['media_id' => $value] : ['articles' => $value];
                break;
            default:
                $content = ['media_id' => $value];
                break;
        }

        return $this->setAttribute($msgType, $content);
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'touser',
            'toparty',
            'totag',
            'msgtype',
            'agentid',
            'safe',
            'text',
            'image',
            'voice',
            'video',
            'file',
            'news',
            'mpnews'
        ];
    }

}