<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/7/2
 * Time: 17:01
 */

namespace cdcchen\wechat\qy\jsapi;


/**
 * Class GroupTicketRequest
 * @package cdcchen\wechat\qy\jsapi
 */
class GroupTicketRequest extends JsApiTicketRequest
{
    /**
     * @inheritdoc
     */
    protected function prepare()
    {
        $this->setQueryParam('type', 'contact');
    }
}