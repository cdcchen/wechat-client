<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 22:18
 */

namespace cdcchen\wechat\qy\suite\push\models;


/**
 * Class CreateAuthEvent
 * @package cdcchen\wechat\qy\suite\push\models
 */
class CreateAuthEvent extends Base
{
    /**
     * @return mixed|null
     */
    public function getAuthCode()
    {
        return $this->get('AuthCode');
    }
}