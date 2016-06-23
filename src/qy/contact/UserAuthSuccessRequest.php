<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/23
 * Time: 21:42
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class UserAuthSuccessRequest
 * @package cdcchen\wechat\qy\contact
 */
class UserAuthSuccessRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/user/authsucc';

    /**
     * @param string $id
     * @return $this
     */
    public function setUserId($id)
    {
        return $this->setQueryParam('userid', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['userid'];
    }
}