<?php

/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/9
 * Time: 22:12
 */
namespace cdcchen\wechat\qy\chat;

use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\base\UpdateAttributeTrait;
use cdcchen\wechat\qy\Client;

class ChatClient extends Client
{
    use UpdateAttributeTrait;

    const CHAT_TYPE_SINGLE = 'single';
    const CHAT_TYPE_GROUP  = 'group';

    const MSG_TYPE_TEXT  = 'text';
    const MSG_TYPE_IMAGE = 'image';
    const MSG_TYPE_FILE  = 'file';
    const MSG_TYPE_VOICE = 'voice';

    const USER_LIST_MIN_COUNT = 3;
    const USER_LIST_MAX_COUNT = 1000;

    const API_CREATE       = '/cgi-bin/chat/create';
    const API_FETCH        = '/cgi-bin/chat/get';
    const API_UPDATE       = '/cgi-bin/chat/update';
    const API_QUIT         = '/cgi-bin/chat/quit';
    const API_CLEAR_NOTIFY = '/cgi-bin/chat/clearnotify';
    const API_SEND         = '/cgi-bin/chat/send';
    const API_SET_MUTE     = '/cgi-bin/chat/setmute';


    public function create($name, $owner, array $user_list, $chat_id = null)
    {
        static::checkCreateArguments($owner, $user_list);
        if (empty($chat_id)) {
            $chat_id = static::generateChatId();
        }

        $attributes = [
            'chatid' => $chat_id,
            'name' => $name,
            'owner' => $owner,
            'userlist' => $user_list,
        ];

        $url = $this->buildUrl(self::API_CREATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) use ($chat_id) {
            return static::handleResponse($response, function ($data)  use ($chat_id) {
                return $chat_id;
            });
        });
    }

    protected static function generateChatId()
    {
        return md5(uniqid() . microtime(true));
    }


    public function fetch($chat_id)
    {
        $url = $this->buildUrl(self::API_FETCH, ['chatid' => $chat_id]);
        $request = HttpClient::get($url);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data['chat_info'];
            });
        });
    }


    ######################### Update #################################

    public function update($chat_id, $op_user, array $attributes = [])
    {
        $attributes = array_merge($this->_updateAttributes, $attributes);
        $attributes['chatid'] = $chat_id;
        $attributes['op_user'] = $op_user;

        if (count($attributes) <= 2) {
            throw new \InvalidArgumentException('There is no attributes need to be updated.');
        }

        $url = $this->buildUrl(self::API_UPDATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }

    public function setName($name)
    {
        return $this->setUpdateAttribute('name', $name);
    }

    public function setOwner($owner)
    {
        return $this->setUpdateAttribute('owner', $owner);
    }

    /**
     * @param array $add_user_list
     * @return $this
     */
    public function setAddUsers(array $add_user_list)
    {
        return $this->setUpdateAttribute('add_user_list', $add_user_list);
    }

    /**
     * @param array $del_user_list
     * @return $this
     */
    public function setDeleteUsers(array $del_user_list)
    {
        return $this->setUpdateAttribute('del_user_list', $del_user_list);
    }

    public function addUsers($chat_id, $op_user, array $add_user_list)
    {
        if (empty($add_user_list)) {
            throw new \InvalidArgumentException('$add_user_list can\'t be empty');
        }

        return $this->setAddUsers($add_user_list)->update($chat_id, $op_user);
    }

    public function removeUsers($chat_id, $op_user, array $del_user_list)
    {
        if (empty($del_user_list)) {
            throw new \InvalidArgumentException('$del_user_list can\'t be empty');
        }

        return $this->setDeleteUsers($del_user_list)->update($chat_id, $op_user);
    }


    public function quit($chat_id, $op_user)
    {
        $attributes = [
            'chatid' => $chat_id,
            'op_user' => $op_user,
        ];

        $url = $this->buildUrl(self::API_QUIT);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }


    public function clearNotify($op_user, $chat = [])
    {
        $attributes = [
            'op_user' => $op_user,
            'chat' => $chat,
        ];

        $url = $this->buildUrl(self::API_CLEAR_NOTIFY);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }


    public function setMute($user_mute_list = [])
    {
        $attributes = ['user_mute_list' => $user_mute_list];

        $url = $this->buildUrl(self::API_SET_MUTE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return isset($data['invaliduser']) ? $data['invaliduser'] : true;
            });
        });
    }

    public function sendText($content, $receiver_id, $sender, $receiver_type)
    {
        $attributes = [
            'text' => ['content' => $content],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_TEXT, $attributes);
    }

    public function sendImage($media_id, $receiver_id, $sender, $receiver_type)
    {
        $attributes = [
            'image' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_IMAGE, $attributes);
    }

    public function sendFile($media_id, $receiver_type, $receiver_id, $sender)
    {
        $attributes = [
            'file' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_FILE, $attributes);
    }

    public function sendVoice($media_id, $receiver_type, $receiver_id, $sender)
    {
        $attributes = [
            'voice' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_VOICE, $attributes);
    }

    public function send($receiver_type, $receiver_id, $sender, $msg_type, $attributes = [])
    {
        $attributes['receiver'] = ['type' => $receiver_type, 'id' => $receiver_id];
        $attributes['sender'] = $sender;
        $attributes['msgtype'] = $msg_type;

        $url = $this->buildUrl(self::API_SEND);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }

    protected static function checkCreateArguments($owner, $user_list)
    {
        $count = count($user_list);
        if ($count < self::USER_LIST_MIN_COUNT || $count > self::USER_LIST_MAX_COUNT) {
            throw new \InvalidArgumentException(sprintf('$user_list must be between %d and %d.',
                self::USER_LIST_MIN_COUNT, self::USER_LIST_MAX_COUNT));
        } elseif (!in_array($owner, $user_list)) {
            throw new \InvalidArgumentException('$owner must be included in the $user_list.');
        } else {
            return true;
        }
    }
}