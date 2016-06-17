<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 10:34
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class TagDeleteRequest
 * @package cdcchen\wechat\qy\contact
 */
class TagDeleteRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/tag/delete';

    /**
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setQueryParam('tagid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['tagid'];
    }
}