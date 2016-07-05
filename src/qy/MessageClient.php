<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午10:11
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\ResponseException;
use cdcchen\wechat\qy\message\InvalidMessageReceiverException;
use cdcchen\wechat\qy\message\MediaMessageSendRequest;
use cdcchen\wechat\qy\message\MessageSendRequest;
use cdcchen\wechat\qy\message\MPNewsMessageSendRequest;
use cdcchen\wechat\qy\message\NewsMessageSendRequest;
use cdcchen\wechat\qy\message\TextMessageSendRequest;

/**
 * Class MessageClient
 * @package cdcchen\wechat\qy\message
 */
class MessageClient extends DefaultClient
{
    /**
     * @param MessageSendRequest $request
     * @return bool
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function send(MessageSendRequest $request)
    {
        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return static::checkResponseData($data);
        });
    }


    ############## send *(text|image|voice|video|file|news|mpnews) shortcut methods ############

    /**
     * @param TextMessageSendRequest $request
     * @param null|string $text
     * @param null|int $agentId
     * @return bool
     */
    public function sendText(TextMessageSendRequest $request, $text, $agentId = null)
    {
        $request->setText($text);
        if (is_int($agentId)) {
            $request->setAgentId($agentId);
        }
        return $this->send($request);
    }

    /**
     * @param MediaMessageSendRequest $request
     * @param null|string $mediaId
     * @param null|int $agentId
     * @return bool
     */
    public function sendImage(MediaMessageSendRequest $request, $mediaId, $agentId = null)
    {
        return $this->sendMedia($request, $mediaId, $agentId);
    }

    /**
     * @param MediaMessageSendRequest $request
     * @param null|string $mediaId
     * @param null|int $agentId
     * @return bool
     */
    public function sendVoice(MediaMessageSendRequest $request, $mediaId, $agentId = null)
    {
        return $this->sendMedia($request, $mediaId, $agentId);
    }

    /**
     * @param MediaMessageSendRequest $request
     * @param null|string $mediaId
     * @param null|int $agentId
     * @return bool
     */
    public function sendVideo(MediaMessageSendRequest $request, $mediaId, $agentId = null)
    {
        return $this->sendMedia($request, $mediaId, $agentId);
    }

    /**
     * @param MediaMessageSendRequest $request
     * @param null|string $mediaId
     * @param null|int $agentId
     * @return bool
     */
    public function sendFile(MediaMessageSendRequest $request, $mediaId, $agentId = null)
    {
        return $this->sendMedia($request, $mediaId, $agentId);
    }

    /**
     * @param MediaMessageSendRequest $request
     * @param null|string $mediaId
     * @param null|int $agentId
     * @return bool
     */
    private function sendMedia(MediaMessageSendRequest $request, $mediaId, $agentId = null)
    {
        $request->setMediaId($mediaId);
        if (is_int($agentId)) {
            $request->setAgentId($agentId);
        }

        return $this->send($request);
    }

    /**
     * @param NewsMessageSendRequest $request
     * @param null $agentId
     * @param \cdcchen\wechat\qy\base\NewsArticle[] $articles
     * @return mixed
     */
    public function sendNews(NewsMessageSendRequest $request, $agentId, $articles)
    {
        $request->setAgentId($agentId)->setArticles($articles);
        return $this->send($request);
    }

    /**
     * @param MPNewsMessageSendRequest $request
     * @param int $agentId
     * @param \cdcchen\wechat\qy\base\MPNewsArticle[] $articles
     * @param string $mediaId
     * @return mixed
     */
    public function sendMPNews(MPNewsMessageSendRequest $request, $agentId, $articles = [], $mediaId = null)
    {
        $request->setAgentId($agentId);
        if ($articles) {
            $request->setArticles($articles);
        } elseif ($mediaId) {
            $request->setMediaId($mediaId);
        } else {
            throw new \InvalidArgumentException('Articles or media id is required.');
        }

        return $this->send($request);
    }


    ########################### send to (user|party|tag) shortcut methods ##############################

    /**
     * @param MessageSendRequest $request
     * @return bool
     */
    public function sendToAllUser(MessageSendRequest $request)
    {
        $request->setToAllUsers();
        return $this->send($request);
    }

    /**
     * @param MessageSendRequest $request
     * @param string|array $users
     * @return bool
     */
    public function sendToUser(MessageSendRequest $request, $users)
    {
        $request->setToUser($users);
        return $this->send($request);
    }

    /**
     * @param MessageSendRequest $request
     * @param string|array $parties
     * @return bool
     */
    public function sendToParty(MessageSendRequest $request, $parties)
    {
        $request->setToDepartment($parties);
        return $this->send($request);
    }

    /**
     * @param MessageSendRequest $request
     * @param string|array $tags
     * @return bool
     */
    public function sendToTag(MessageSendRequest $request, $tags)
    {
        $request->setToTag($tags);
        return $this->send($request);
    }


    /**
     * Check response is valid
     *
     * @param array|mixed $response
     * @return bool
     * @throws InvalidMessageReceiverException
     */
    private static function checkResponseData($response)
    {
        $invalid = [
            'invaliduser' => $response['invaliduser'],
            'invalidparty' => $response['invalidparty'],
            'invalidtag' => $response['invalidtag'],
        ];
        $invalid = array_filter($invalid);

        if ($invalid) {
            $invalidMsg = [];
            foreach ($invalid as $key => $value) {
                $invalidMsg[] = $key . ': ' . $value;
            }
            $invalidText = join('; ', $invalidMsg);

            throw new InvalidMessageReceiverException('Invalid user or party or tag. ' . $invalidText);
        } else {
            return true;
        }
    }
}