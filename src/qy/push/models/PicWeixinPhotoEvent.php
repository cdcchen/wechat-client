<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class PicWeixinPhotoEvent
 * @package cdcchen\wechat\qy\push\models
 */
class PicWeixinPhotoEvent extends EventMessage
{
    use ParseSendPicsInfoTrait;
    use EventKeyTrait;


}