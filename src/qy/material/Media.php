<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:35
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\wechat\qy\base\BaseModel;

class Media extends BaseModel
{
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE  = 'file';
    const TYPE_NEWS  = 'mpnews';


    protected function fields()
    {
        // TODO: Implement fields() method.
    }


}