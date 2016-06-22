<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 15:38
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class EventKeyTrait
 * @package cdcchen\wechat\qy\push\models
 */
trait EventKeyTrait
{
    /**
     * @return string
     */
    public function getEventKey()
    {
        return $this->get('EventKey');
    }

}