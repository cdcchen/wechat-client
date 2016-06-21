<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class EnterAgentEvent
 * @package cdcchen\wechat\qy\push\models
 */
class EnterAgentEvent extends Event
{
    /**
     * @return string
     */
    public function getEventKey()
    {
        return $this->get('EventKey');
    }
}