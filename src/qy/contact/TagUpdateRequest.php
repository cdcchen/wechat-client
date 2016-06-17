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
 * Class TagUpdateRequest
 * @package cdcchen\wechat\qy\contact
 */
class TagUpdateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/tag/update';

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setData('tagname', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('tagid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['tagid', 'tagname'];
    }
}