<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午10:11
 */

namespace cdcchen\wechat\qy\message;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\ResponseException;
use cdcchen\wechat\base\InvalidMembersException;
use cdcchen\wechat\qy\Client;

/**
 * Class MessageClient
 * @package cdcchen\wechat\qy\message
 */
class MessageClient extends Client
{
    /**
     * api send path
     */
    const API_SEND = '/cgi-bin/message/send';


    /**
     * @param string $message
     * @return bool
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function send($message)
    {
        $attributes = ($message instanceof Message) ? $message->toArray() : $message;

        $url = $this->buildUrl(self::API_SEND);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return static::checkResponseData($data);
        });
    }


    ############## send *(text|image|voice|video|file|news|mpnews) shortcut methods ############

    /**
     * @param TextMessage $message
     * @param null|string $text
     * @param null|int $agent_id
     * @return bool
     */
    public function sendText(TextMessage $message, $text = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_TEXT);
        if ($text) {
            $message->setText($text);
        }
        if ($agent_id) {
            $message->setAgentId($agent_id);
        }

        return $this->send($message->toArray());
    }

    /**
     * @param MediaMessage $message
     * @param null|string $media_id
     * @param null|int $agent_id
     * @return bool
     */
    public function sendImage(MediaMessage $message, $media_id = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_IMAGE);
        return $this->sendMedia($message, $media_id, $agent_id);
    }

    /**
     * @param MediaMessage $message
     * @param null|string $media_id
     * @param null|int $agent_id
     * @return bool
     */
    public function sendVoice(MediaMessage $message, $media_id = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_VOICE);
        return $this->sendMedia($message, $media_id, $agent_id);
    }

    /**
     * @param MediaMessage $message
     * @param null|string $media_id
     * @param null|int $agent_id
     * @return bool
     */
    public function sendVideo(MediaMessage $message, $media_id = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_VIDEO);
        return $this->sendMedia($message, $media_id, $agent_id);
    }

    /**
     * @param MediaMessage $message
     * @param null|string $media_id
     * @param null|int $agent_id
     * @return bool
     */
    public function sendFile(MediaMessage $message, $media_id = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_FILE);
        return $this->sendMedia($message, $media_id, $agent_id);
    }

    /**
     * @param MediaMessage $message
     * @param null|string $media_id
     * @param null|int $agent_id
     * @return bool
     */
    private function sendMedia(MediaMessage $message, $media_id = null, $agent_id = null)
    {
        if ($media_id) {
            $message->setMediaId($media_id);
        }
        if ($agent_id) {
            $message->setAgentId($agent_id);
        }

        return $this->send($message->toArray());
    }

    /**
     * @param NewsMessage $message
     * @param null $agent_id
     * @param null $articles
     * @return mixed
     */
    public function sendNews(NewsMessage $message, $agent_id = null, $articles = null)
    {
        $message->setMsgType(Message::TYPE_NEWS);
        if ($articles) {
            $attributes['news']['articles'] = $articles;
        }
        if ($agent_id) {
            $message->setAgentId($agent_id);
        }

        return $this->send($message->toArray());
    }

    /**
     * @param MPNewsMessage $message
     * @param null $agent_id
     * @param null $articles
     * @return mixed
     */
    public function sendMPNews(MPNewsMessage $message, $agent_id = null, $articles = null)
    {
        $message->setMsgType(Message::TYPE_MPNEWS);
        if ($agent_id) {
            $message->setAgentId($agent_id);
        }
        if (is_array($articles)) {
            $attributes['mpnews']['articles'] = $articles;
        } else {
            $attributes['mpnews']['media_id'] = $articles;
        }

        return $this->send($message->toArray());
    }


    ########################### send to (user|party|tag) shortcut methods ##############################

    /**
     * @param Message $message
     * @return bool
     */
    public function sendToAllUser(Message $message)
    {
        $message->setToAllUser();
        return $this->send($message->toArray());
    }

    /**
     * @param Message $message
     * @param string|array $to_user
     * @return bool
     */
    public function sendToUser(Message $message, $to_user)
    {
        $message->setToUser($to_user);
        return $this->send($message->toArray());
    }

    /**
     * @param Message $message
     * @param string|array $to_party
     * @return bool
     */
    public function sendToParty(Message $message, $to_party)
    {
        $message->setToParty($to_party);
        return $this->send($message->toArray());
    }

    /**
     * @param Message $message
     * @param string|array $to_tag
     * @return bool
     */
    public function sendToTag(Message $message, $to_tag)
    {
        $message->setToTag($to_tag);
        return $this->send($message->toArray());
    }


    /**
     * Check response is valid
     *
     * @param array|mixed $response
     * @return bool
     * @throws ResponseException
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

            throw new InvalidMembersException('Invalid user or party or tag. ' . $invalidText);
        } else {
            return true;
        }
    }
}
