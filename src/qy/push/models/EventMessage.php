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
class EventMessage extends Message
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
    public function getEventMessage()
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

    /**
     * @return bool
     */
    public function isSubscribeEvent()
    {
        return $this->isEventType(self::EVENT_SUBSCRIBE);
    }

    /**
     * @return bool
     */
    public function isUnSubscribeEvent()
    {
        return $this->isEventType(self::EVENT_UNSUBSCRIBE);
    }

    /**
     * @return bool
     */
    public function isLocationEvent()
    {
        return $this->isEventType(self::EVENT_LOCATION);
    }

    /**
     * @return bool
     */
    public function isClickEvent()
    {
        return $this->isEventType(self::EVENT_CLICK);
    }

    /**
     * @return bool
     */
    public function isViewEvent()
    {
        return $this->isEventType(self::EVENT_VIEW);
    }

    /**
     * @return bool
     */
    public function isScanCodePushEvent()
    {
        return $this->isEventType(self::EVENT_SCANCODE_PUSH);
    }

    /**
     * @return bool
     */
    public function isScanCodeWaitMsgEvent()
    {
        return $this->isEventType(self::EVENT_SCANCODE_WAITMSG);
    }

    /**
     * @return bool
     */
    public function isPicSysPhotoEvent()
    {
        return $this->isEventType(self::EVENT_PIC_SYSPHOTO);
    }

    /**
     * @return bool
     */
    public function isPicPhotoOrAlbumEvent()
    {
        return $this->isEventType(self::EVENT_PIC_PHOTO_OR_ALBUM);
    }

    /**
     * @return bool
     */
    public function isPicWeixinPhotoEvent()
    {
        return $this->isEventType(self::EVENT_PIC_WEIXIN_PHOTO);
    }

    /**
     * @return bool
     */
    public function isLocationSelectEvent()
    {
        return $this->isEventType(self::EVENT_LOCATION_SELECT);
    }

    /**
     * @return bool
     */
    public function isEnterAgentEvent()
    {
        return $this->isEventType(self::EVENT_ENTER_AGENT);
    }

    /**
     * @return bool
     */
    public function isBatchJobResultEvent()
    {
        return $this->isEventType(self::EVENT_BATCH_JOB_RESULT);
    }

    /**
     * @param string $event
     * @return bool
     */
    private function isEventType($event)
    {
        return $this->isEventMessage() && $this->getEvent() === $event;
    }
}