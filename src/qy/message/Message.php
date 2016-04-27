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
     *
     */
    const MAX_USER_COUNT  = 1000;
    /**
     *
     */
    const MAX_PARTY_COUNT = 100;

    /**
     *
     */
    const TYPE_TEXT   = 'text';
    /**
     *
     */
    const TYPE_IMAGE  = 'image';
    /**
     *
     */
    const TYPE_VOICE  = 'voice';
    /**
     *
     */
    const TYPE_VIDEO  = 'video';
    /**
     *
     */
    const TYPE_FILE   = 'file';
    /**
     *
     */
    const TYPE_NEWS   = 'news';
    /**
     *
     */
    const TYPE_MPNEWS = 'mpnews';

    /**
     *
     */
    const SAFE_YES = 1;
    /**
     *
     */
    const SAFE_NO = 0;

    /**
     *
     */
    const ALL_USER_FLAG = '@all';

    /**
     * @param $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setAttribute('agentid', $id);
    }

    /**
     * @param $values
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
     * @param $values
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
     * @param $values
     * @return $this
     */
    public function setToTag($values)
    {
        return $this->setAttribute('totag', is_array($values) ? join('|', $values) : $values);
    }

    /**
     * @param $type
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
     * @param $value
     * @return $this
     */
    public function setSafe($value)
    {
        return $this->setAttribute('safe', $value ? self::SAFE_YES : self::SAFE_NO);
    }

    /**
     * @param $value
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