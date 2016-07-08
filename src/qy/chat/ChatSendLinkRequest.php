<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 00:20
 */

namespace cdcchen\wechat\qy\chat;


/**
 * Class ChatSendLinkRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatSendLinkRequest extends ChatSendMessageRequest
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setData('msgtype', ChatMessage::MSG_TYPE_LINK);
    }

    /**
     * @param string $title
     * @param string $url
     * @param string $thumbMediaId
     * @param string $description
     * @return $this
     */
    public function setLink($title, $url, $thumbMediaId, $description = '')
    {
        if (empty($title) || empty($thumbMediaId) || empty($thumbMediaId)) {
            throw new \InvalidArgumentException('title|url|thumbMediaId is required.');
        }

        return $this->setData('link', [
            'title' => $title,
            'url' => $url,
            'thumb_media_id' => $thumbMediaId,
            'description' => $description,
        ]);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        $params = parent::getRequireParams();
        $params[] = 'link';
        return $params;
    }
}