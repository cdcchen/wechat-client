<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:18
 */

namespace cdcchen\wechat\qy\message;


/**
 * Class MediaMessage
 * @package cdcchen\wechat\qy\message
 */
class MediaMessage extends Message
{
    /**
     * @param string $media_id
     * @return $this
     * @throws \Exception
     */
    public function setMediaId($media_id)
    {
        return $this->setContent($media_id);
    }
}