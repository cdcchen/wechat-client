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

/**
 * Class ChatClient
 * @package cdcchen\wechat\qy\chat
 */
class ChatClient extends Client
{
    use UpdateAttributeTrait;

    /**
     * single char type
     */
    const CHAT_TYPE_SINGLE = 'single';
    /**
     * group chat type
     */
    const CHAT_TYPE_GROUP = 'group';

    /**
     *
     */
    const USER_LIST_MIN_COUNT = 3;
    /**
     *
     */
    const USER_LIST_MAX_COUNT = 1000;

    /**
     * Api create path
     */
    const API_CREATE = '/cgi-bin/chat/create';
    /**
     * Api fetch path
     */
    const API_FETCH = '/cgi-bin/chat/get';
    /**
     * Api update path
     */
    const API_UPDATE = '/cgi-bin/chat/update';
    /**
     * Api quit path
     */
    const API_QUIT = '/cgi-bin/chat/quit';
    /**
     * Api clear_notify path
     */
    const API_CLEAR_NOTIFY = '/cgi-bin/chat/clearnotify';
    /**
     * Api send path
     */
    const API_SEND = '/cgi-bin/chat/send';
    /**
     * Api setmute path
     */
    const API_SET_MUTE = '/cgi-bin/chat/setmute';


    /**
     * @param string $name
     * @param $owner
     * @param string array $user_list
     * @param null|string $chat_id
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) use ($chat_id) {
            return $chat_id;
        });
    }

    /**
     * @return string
     */
    protected static function generateChatId()
    {
        return md5(uniqid() . microtime(true));
    }


    /**
     * @param string $chat_id
     * @return bool|ChatGroup
     * @throws \cdcchen\wechat\base\RequestException|\cdcchen\wechat\base\ResponseException
     */
    public function fetch($chat_id)
    {
        $url = $this->buildUrl(self::API_FETCH, ['chatid' => $chat_id]);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return new $data['chat_info'];
        });
    }


    ######################### Update #################################

    /**
     * @param string $chat_id
     * @param string $op_user
     * @param array $attributes
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $name
     * @return $this
     */
    public function updateName($name)
    {
        return $this->setUpdateAttribute('name', $name);
    }

    /**
     * @param string $owner
     * @return $this
     */
    public function updateOwner($owner)
    {
        return $this->setUpdateAttribute('owner', $owner);
    }

    /**
     * @param array $add_user_list
     * @return $this
     */
    public function updateAddUsers(array $add_user_list)
    {
        return $this->setUpdateAttribute('add_user_list', $add_user_list);
    }

    /**
     * @param array $del_user_list
     * @return $this
     */
    public function updateDeleteUsers(array $del_user_list)
    {
        return $this->setUpdateAttribute('del_user_list', $del_user_list);
    }

    /**
     * @param string $chat_id
     * @param string $op_user
     * @param array $add_user_list
     * @return bool
     */
    public function addUsers($chat_id, $op_user, array $add_user_list)
    {
        if (empty($add_user_list)) {
            throw new \InvalidArgumentException('$add_user_list can\'t be empty');
        }

        return $this->updateAddUsers($add_user_list)->update($chat_id, $op_user);
    }

    /**
     * @param string $chat_id
     * @param string $op_user
     * @param array $del_user_list
     * @return bool
     */
    public function removeUsers($chat_id, $op_user, array $del_user_list)
    {
        if (empty($del_user_list)) {
            throw new \InvalidArgumentException('$del_user_list can\'t be empty');
        }

        return $this->updateDeleteUsers($del_user_list)->update($chat_id, $op_user);
    }


    /**
     * @param string $chat_id
     * @param string $op_user
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function quit($chat_id, $op_user)
    {
        $attributes = [
            'chatid' => $chat_id,
            'op_user' => $op_user,
        ];

        $url = $this->buildUrl(self::API_QUIT);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }


    /**
     * @param string $op_user
     * @param array $chat
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function clearNotify($op_user, $chat = [])
    {
        $attributes = [
            'op_user' => $op_user,
            'chat' => $chat,
        ];

        $url = $this->buildUrl(self::API_CLEAR_NOTIFY);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }


    /**
     * @param array $user_mute_list
     * @return bool|array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function setMute($user_mute_list = [])
    {
        $attributes = ['user_mute_list' => $user_mute_list];

        $url = $this->buildUrl(self::API_SET_MUTE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return isset($data['invaliduser']) ? $data['invaliduser'] : true;
        });
    }

    /**
     * @param string $content
     * @param string $receiver_id
     * @param string $sender
     * @param int $receiver_type
     * @return bool
     */
    public function sendText($content, $receiver_id, $sender, $receiver_type)
    {
        $attributes = [
            'text' => ['content' => $content],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, ChatMessage::MSG_TYPE_TEXT, $attributes);
    }

    /**
     * @param string $media_id
     * @param string $receiver_id
     * @param string $sender
     * @param int $receiver_type
     * @return bool
     */
    public function sendImage($media_id, $receiver_id, $sender, $receiver_type)
    {
        $attributes = [
            'image' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, ChatMessage::MSG_TYPE_IMAGE, $attributes);
    }

    /**
     * @param string $media_id
     * @param int $receiver_type
     * @param string $receiver_id
     * @param string $sender
     * @return bool
     */
    public function sendFile($media_id, $receiver_type, $receiver_id, $sender)
    {
        $attributes = [
            'file' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, ChatMessage::MSG_TYPE_FILE, $attributes);
    }

    /**
     * @param string $media_id
     * @param int $receiver_type
     * @param string $receiver_id
     * @param string $sender
     * @return bool
     */
    public function sendVoice($media_id, $receiver_type, $receiver_id, $sender)
    {
        $attributes = [
            'voice' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, ChatMessage::MSG_TYPE_VOICE, $attributes);
    }

    /**
     * @param int $receiver_type
     * @param string $receiver_id
     * @param string $sender
     * @param string $msg_type
     * @param array $attributes
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function send($receiver_type, $receiver_id, $sender, $msg_type, $attributes = [])
    {
        $attributes['receiver'] = ['type' => $receiver_type, 'id' => $receiver_id];
        $attributes['sender'] = $sender;
        $attributes['msgtype'] = $msg_type;

        $url = $this->buildUrl(self::API_SEND);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $owner
     * @param array $user_list
     * @return bool
     */
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