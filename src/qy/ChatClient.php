<?php

/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/9
 * Time: 22:12
 */
namespace cdcchen\wechat\qy\chat;

use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\DefaultClient;

/**
 * Class ChatClient
 * @package cdcchen\wechat\qy\chat
 */
class ChatClient extends DefaultClient
{
    /**
     * single char type
     */
    const TYPE_SINGLE = 'single';
    /**
     * group chat type
     */
    const TYPE_GROUP = 'group';


    /**
     * @param string $name
     * @param string $owner
     * @param string array $users
     * @param null|string $chatId
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function create($name, $owner, array $users, $chatId = null)
    {
        if (empty($chatId)) {
            $chatId = static::generateChatId();
        }

        $request = (new ChatCreateRequest())->setName($name)
                                            ->setOwner($owner)
                                            ->setUsers($users)
                                            ->setId($chatId);

        return $this->sendRequest($request, function (HttpResponse $response) use ($chatId) {
            return $chatId;
        });
    }

    /**
     * @return string
     */
    private static function generateChatId()
    {
        return md5(uniqid() . microtime(true));
    }

    /**
     * @param string $id
     * @return ChatGroup
     * @deprecated
     */
    public function fetch($id)
    {
        return $this->getInfo($id);
    }

    /**
     * @param string $id
     * @return ChatGroup
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getInfo($id)
    {
        $request = (new ChatInfoRequest())->setId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return new ChatGroup($data['chat_info']);
        });
    }


    /**
     * @param ChatUpdateRequest $request
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function update(ChatUpdateRequest $request)
    {
        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $chatId
     * @param string $opUser
     * @param array $users
     * @return bool
     */
    public function addUsers($chatId, $opUser, array $users)
    {
        if (empty($users)) {
            throw new \InvalidArgumentException('Add user list can not be empty');
        }

        $request = (new ChatUpdateRequest())->setId($chatId)
                                            ->setOperateUser($opUser)
                                            ->setAddUsers($users);

        return $this->update($request);
    }

    /**
     * @param string $chatId
     * @param string $opUser
     * @param array $users
     * @return bool
     */
    public function removeUsers($chatId, $opUser, array $users)
    {
        if (empty($del_user_list)) {
            throw new \InvalidArgumentException('Delete user list can not be empty');
        }

        $request = (new ChatUpdateRequest())->setId($chatId)
                                            ->setOperateUser($opUser)
                                            ->setDeleteUsers($users);

        return $this->update($request);
    }


    /**
     * @param string $chatId
     * @param string $opUser
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function quit($chatId, $opUser)
    {
        $request = (new ChatQuitRequest())->setId($chatId)->setOperateUser($opUser);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }


    /**
     * @param string $opUser
     * @param string $chatType
     * @param string $id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function clearNotify($opUser, $chatType, $id)
    {
        $request = (new ChatClearNotifyRequest())->setOperateUser($opUser)->setChat($chatType, $id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }


    /**
     * @param array $openUsers
     * @param array $closeUsers
     * @return bool|array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function setMute(array $openUsers, array $closeUsers = [])
    {
        $request = (new ChatSetMuteRequest())->setUsers($openUsers, $closeUsers);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return isset($data['invaliduser']) ? $data['invaliduser'] : true;
        });
    }

    /**
     * @param string $receiverType
     * @param string $receiverId
     * @param string $sender
     * @param string $msgType
     * @param string|array $content
     * @return bool
     * @throws \Exception
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function send($receiverType, $receiverId, $sender, $msgType, $content)
    {
        $request = (new ChatSendMessageRequest())->setReceiver($receiverType, $receiverId)
                                                 ->setSender($sender)
                                                 ->setMsgType($msgType)
                                                 ->setContent($msgType, $content);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param $content
     * @param string $receiverId
     * @param string $sender
     * @param string $receiverType
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function sendText($content, $receiverId, $sender, $receiverType)
    {
        $request = (new ChatSendTextRequest())->setReceiver($receiverType, $receiverId)
                                              ->setSender($sender)
                                              ->setText($content);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $mediaId
     * @param string $receiverId
     * @param string $sender
     * @param string $receiverType
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function sendImage($mediaId, $receiverId, $sender, $receiverType)
    {
        $request = (new ChatSendImageRequest())->setReceiver($receiverType, $receiverId)
                                               ->setSender($sender)
                                               ->setMediaId($mediaId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $mediaId
     * @param string $receiverType
     * @param string $receiverId
     * @param string $sender
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function sendFile($mediaId, $receiverType, $receiverId, $sender)
    {
        $request = (new ChatSendFileRequest())->setReceiver($receiverType, $receiverId)
                                              ->setSender($sender)
                                              ->setMediaId($mediaId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $mediaId
     * @param string $receiverType
     * @param string $receiverId
     * @param string $sender
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function sendVoice($mediaId, $receiverType, $receiverId, $sender)
    {
        $request = (new ChatSendVoiceRequest())->setReceiver($receiverType, $receiverId)
                                               ->setSender($sender)
                                               ->setMediaId($mediaId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $receiverType
     * @param string $receiverId
     * @param string $sender
     * @param string $title
     * @param string $url
     * @param string $thumbMediaId
     * @param string $description
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function sendLink($receiverType, $receiverId, $sender, $title, $url, $thumbMediaId, $description = '')
    {
        $request = (new ChatSendLinkRequest())->setReceiver($receiverType, $receiverId)
                                              ->setSender($sender)
                                              ->setLink($title, $url, $thumbMediaId, $description);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }
}