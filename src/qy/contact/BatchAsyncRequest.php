<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 12:30
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\auth\CallbackCredential;
use cdcchen\wechat\base\BaseRequest;

/**
 * Class BatchAsyncRequest
 * @package cdcchen\wechat\qy\contact
 */
abstract class BatchAsyncRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';

    /**
     * @param string $value
     * @return $this
     */
    public function setMediaId($value)
    {
        return $this->setData('media_id', $value);
    }

    /**
     * @param CallbackCredential $credential
     * @return $this
     */
    public function setCallback(CallbackCredential $credential)
    {
        return $this->setData('callback', $credential->toArray());
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['media_id'];
    }
}