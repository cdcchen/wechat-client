<?php

/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/9
 * Time: 22:12
 */
namespace weixin\qy\chat;

use phpplus\net\CUrl;
use weixin\qy\base\UpdateTrait;
use weixin\qy\Request;

class Chat extends Request
{
    use UpdateTrait;

    const CHAT_TYPE_SINGLE = 'single';
    const CHAT_TYPE_GROUP = 'group';

    const MSG_TYPE_TEXT = 'text';
    const MSG_TYPE_IMAGE = 'image';
    const MSG_TYPE_FILE = 'file';
    const MSG_TYPE_VOICE = 'voice';

    const USER_LIST_MIN_COUNT = 3;
    const USER_LIST_MAX_COUNT = 1000;

    const API_CREATE = '/cgi-bin/chat/create';
    const API_FETCH = '/cgi-bin/chat/get';
    const API_UPDATE = '/cgi-bin/chat/update';
    const API_QUIT = '/cgi-bin/chat/quit';
    const API_CLEAR_NOTIFY = '/cgi-bin/chat/clearnotify';
    const API_SEND = '/cgi-bin/chat/send';
    const API_SET_MUTE = '/cgi-bin/chat/setmute';


    public function create($chat_id, $name, $owner, array $user_list)
    {
        static::checkCreateArguments($owner, $user_list);

        $url = $this->getUrl(self::API_CREATE);

        $attributes = [
            'chatid' => $chat_id,
            'name' => $name,
            'owner' => $owner,
            'userlist' => $user_list,
        ];

        $request = new CUrl();
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function (CUrl $request) {
            return static::handleResponse($request, function ($response) {
                return true;
            });
        });
    }


    public function fetch($chat_id)
    {
        $url = $this->getUrl(self::API_FETCH, ['chatid' => $chat_id]);

        $request = new CUrl();
        $request->get($url);

        return static::handleRequest($request, function (CUrl $request) {
            return static::handleResponse($request, function ($response) {
                return $response['chat_info'];
            });
        });
    }




    ######################### Update #################################

    public function update($chat_id, $op_user, array $attributes = [])
    {
        $attributes = array_merge($this->_updateAttributes, $attributes);
        $attributes['chatid'] = $chat_id;
        $attributes['op_user'] = $op_user;

        if (count($attributes) <= 2)
            throw new \InvalidArgumentException('There is no attributes need to be updated.');

        $request = new CUrl();
        $url = $this->getUrl(self::API_UPDATE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
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
        if (empty($add_user_list))
            throw new \InvalidArgumentException('$add_user_list can\'t be empty');

        return $this->setAddUsers($add_user_list)->update($chat_id, $op_user);
    }

    public function removeUsers($chat_id, $op_user, array $del_user_list)
    {
        if (empty($del_user_list))
            throw new \InvalidArgumentException('$del_user_list can\'t be empty');

        return $this->setDeleteUsers($del_user_list)->update($chat_id, $op_user);
    }




    public function quit($chat_id, $op_user)
    {
        $url = $this->getUrl(self::API_QUIT);

        $request = new CUrl();

        $attributes = [
            'chatid' => $chat_id,
            'op_user' => $op_user,
        ];

        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function (CUrl $request) {
            return static::handleResponse($request, function ($response) {
                return true;
            });
        });
    }


    public function clearNotify($op_user, $chat = [])
    {
        $url = $this->getUrl(self::API_CLEAR_NOTIFY);

        $request = new CUrl();

        $attributes = [
            'op_user' => $op_user,
            'chat' => $chat,
        ];

        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function (CUrl $request) {
            return static::handleResponse($request, function ($response) {
                return true;
            });
        });
    }


    public function setMute($user_mute_list = [])
    {
        $url = $this->getUrl(self::API_SET_MUTE);

        $request = new CUrl();

        $attributes = ['user_mute_list' => $user_mute_list];

        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function (CUrl $request) {
            return static::handleResponse($request, function ($response) {
                return isset($response['invaliduser']) ? $response['invaliduser'] : true;
            });
        });
    }

    public function sendText($receiver_type, $receiver_id, $sender, $content)
    {
        $attributes = [
            'text' => ['content' => $content],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_TEXT, $attributes);
    }

    public function sendImage($receiver_type, $receiver_id, $sender, $media_id)
    {
        $attributes = [
            'image' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_IMAGE, $attributes);
    }

    public function sendFile($receiver_type, $receiver_id, $sender, $media_id)
    {
        $attributes = [
            'file' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_FILE, $attributes);
    }

    public function sendVoice($receiver_type, $receiver_id, $sender, $media_id)
    {
        $attributes = [
            'voice' => ['media_id' => $media_id],
        ];
        return $this->send($receiver_type, $receiver_id, $sender, self::MSG_TYPE_VOICE, $attributes);
    }

    public function send($receiver_type, $receiver_id, $sender, $msg_type, $attributes = [])
    {
        $url = $this->getUrl(self::API_SEND);

        $request = new CUrl();

        $attributes['receiver'] = ['type' => $receiver_type, 'id' => $receiver_id];
        $attributes['sender'] = $sender;
        $attributes['msgtype'] = $msg_type;

        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function (CUrl $request) {
            return static::handleResponse($request, function ($response) {
                return true;
            });
        });
    }

    protected static function checkCreateArguments($owner, $user_list)
    {
        $count = count($user_list);
        if ($count < self::USER_LIST_MIN_COUNT || $count > self::USER_LIST_MAX_COUNT)
            throw new \InvalidArgumentException(sprintf('$user_list must be between %d and %d.', self::USER_LIST_MIN_COUNT, self::USER_LIST_MAX_COUNT));
        elseif (!in_array($owner, $user_list))
            throw new \InvalidArgumentException('$owner must be included in the $user_list.');
        else
            return true;
    }
}