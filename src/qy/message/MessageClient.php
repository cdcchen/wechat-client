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
use cdcchen\wechat\qy\Client;

class MessageClient extends Client
{
    const API_SEND = '/cgi-bin/message/send';


    public function send($message)
    {
        $attributes = ($message instanceof Message) ? $message->toArray() : $message;

        $url = $this->buildUrl(self::API_SEND);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return static::checkResponse($data);
            });
        });
    }


    ############## send *(text|image|voice|video|file|news|mpnews) shortcut methods ############

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

    public function sendImage(MediaMessage $message, $media = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_IMAGE);
        return $this->sendMedia($message, $media, $agent_id);
    }

    public function sendVoice(MediaMessage $message, $media = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_VOICE);
        return $this->sendMedia($message, $media, $agent_id);
    }

    public function sendVideo(MediaMessage $message, $media = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_VIDEO);
        return $this->sendMedia($message, $media, $agent_id);
    }

    public function sendFile(MediaMessage $message, $media = null, $agent_id = null)
    {
        $message->setMsgType(Message::TYPE_FILE);
        return $this->sendMedia($message, $media, $agent_id);
    }

    private function sendMedia(MediaMessage $message, $media = null, $agent_id = null)
    {
        if ($media) {
            $message->setMediaId($media);
        }
        if ($agent_id) {
            $message->setAgentId($agent_id);
        }

        return $this->send($message->toArray());
    }

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

    public function sendToAllUser(Message $message)
    {
        $message->setToAllUser();
        return $this->send($message->toArray());
    }

    public function sendToUser(Message $message, $to_user)
    {
        $message->setToUser($to_user);
        return $this->send($message->toArray());
    }

    public function sendToParty(Message $message, $to_party)
    {
        $message->setToParty($to_party);
        return $this->send($message->toArray());
    }

    public function sendToTag(Message $message, $to_tag)
    {
        $message->setToTag($to_tag);
        return $this->send($message->toArray());
    }


    /**
     * Check response is valid
     *
     * @param $response
     * @return bool
     * @throws ResponseException
     */
    private static function checkResponse($response)
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

            throw new ResponseException('Invalid user or party or tag. ' . $invalidText);
        } else {
            return true;
        }
    }
}