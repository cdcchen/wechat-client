<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 22:18
 */

namespace cdcchen\wechat\qy\suite\push\models;


/**
 * Class AuthChangeEvent
 * @package cdcchen\wechat\qy\suite\push\models
 */
class AuthChangeEvent extends Base
{
    /**
     * @return mixed|null
     */
    public function getAuthCorpId()
    {
        return $this->get('AuthCorpId');
    }
}