<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:22
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class Event
 * @package cdcchen\wechat\qy\push\models
 */
class Event extends Message
{
    const EVENT_SUBSCRIBE          = 'subscribe';
    const EVENT_UNSUBSCRIBE        = 'unsubscribe';
    const EVENT_LOCATION           = 'location';
    const EVENT_CLICK              = 'click';
    const EVENT_VIEW               = 'view';
    const EVENT_SCANCODE_PUSH      = 'scancode_push';
    const EVENT_SCANCODE_WAITMSG   = 'scancode_waitmsg';
    const EVENT_PIC_SYSPHOTO       = 'pic_sysphoto';
    const EVENT_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';
    const EVENT_PIC_WEIXIN_PHOTO   = 'pic_weixin';
    const EVENT_LOCATION_SELECT    = 'location_select';
    const EVENT_ENTER_AGENT        = 'enter_agent';
    const EVENT_BATCH_JOB_RESULT   = 'batch_job_result';

    /**
     * @return bool
     */
    public function getIsEvent()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->get('Event');
    }
}