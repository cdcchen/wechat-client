<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 23:19
 */

namespace cdcchen\wechat\qy\chat;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ChatSetMuteRequest
 * @package cdcchen\wechat\qy\chat
 */
class ChatSetMuteRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/chat/setmute';

    /**
     * @param array $openUsers
     * @param array $closeUsers
     * @return $this
     */
    public function setUsers(array $openUsers, array $closeUsers = [])
    {
        $users = [];
        foreach ($openUsers as $user) {
            $users[] = ['userid' => $user, 'status' => 1];
        }
        foreach ($closeUsers as $user) {
            $users[] = ['userid' => $user, 'status' => 0];
        }

        return $this->setData('user_mute_list', $users);
    }

    /**
     * @return array
     */
    public function getRequireParams()
    {
        return ['user_mute_list'];
    }
}