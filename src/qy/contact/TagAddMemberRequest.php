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
 * Class TagAddMemberRequest
 * @package cdcchen\wechat\qy\contact
 */
class TagAddMemberRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/tag/addtagusers';

    /**
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('tagid', $value);
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setUsers(array $value)
    {
        return $this->setData('userlist', $value);
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setDepartments(array $value)
    {
        return $this->setData('partylist', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['tagid', 'userlist|partylist'];
    }
}