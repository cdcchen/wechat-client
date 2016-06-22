<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 22:18
 */

namespace cdcchen\wechat\qy\suite\push\models;


/**
 * Class SuiteTicketEvent
 * @package cdcchen\wechat\qy\suite\push\models
 */
class SuiteTicketEvent extends Base
{
    /**
     * @return mixed|null
     */
    public function getSuiteTicket()
    {
        return $this->get('SuiteTicket');
    }
}