<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午1:48
 */

namespace weixin\qy\contact;


use phpplus\net\CUrl;
use weixin\qy\base\UpdateTrait;
use weixin\qy\Request;

class User extends Request
{
    use UpdateTrait;

    const STATUS_FOLLOWED = 1;
    const STATUS_FORBIDDEN = 2;
    const STATUS_NOT_FOLLOWED = 4;

    const INVITE_TYPE_WEIXIN = 1;
    const INVITE_TYPE_EMAIL = 2;

    const API_CREATE                = '/cgi-bin/user/create';
    const API_UPDATE                = '/cgi-bin/user/update';
    const API_DELETE                = '/cgi-bin/user/delete';
    const API_GET_ITEM              = '/cgi-bin/user/get';
    const API_SIMPLE_LIST           = '/cgi-bin/user/simplelist';
    const API_DETAIL_LIST           = '/cgi-bin/user/list';
    const API_BATCH_DELETE          = '/cgi-bin/user/batchdelete';
    const API_CONVERT_TO_OPENID     = '/cgi-bin/user/convert_to_openid';
    const API_CONVERT_TO_USERID     = '/cgi-bin/user/convert_to_userid';
    const API_INVITE                = '/cgi-bin/invite/send';



    public function create(array $attributes, array $ext_attr = [])
    {
        if ($ext_attr)
            $attributes['extattr'] = $ext_attr;

        $request = new CUrl();
        $url = $this->getUrl(self::API_CREATE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function update($user_id, $attributes = [])
    {
        $attributes = array_merge($this->_updateAttributes, $attributes);
        $attributes['userid'] = $user_id;
        if (count($attributes) <= 1)
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

    public function delete($user_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_DELETE);
        $request->get($url, ['userid' => $user_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function batchDelete($users)
    {
        $attributes = ['useridlist' => $users];

        $request = new CUrl();
        $url = $this->getUrl(self::API_BATCH_DELETE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function fetch($user_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_ITEM);
        $request->get($url, ['userid' => $user_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response;
            });
        });

    }

    public function getSimpleList($department_id, $status = 0, $fetch_child = false)
    {
        $attributes = [
            'department_id' => (int)$department_id,
            'status' => (int)$status,
            'fetch_child' => $fetch_child ? 1 : 0,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_SIMPLE_LIST);
        $request->get($url, $attributes);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['userlist'];
            });
        });
    }

    public function getDetailList($department_id, $status = 0, $fetch_child = false)
    {
        $attributes = [
            'department_id' => (int)$department_id,
            'status' => (int)$status,
            'fetch_child' => $fetch_child ? 1 : 0,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_DETAIL_LIST);
        $request->get($url, $attributes);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['userlist'];
            });
        });
    }

    public function invite($user_id)
    {
        $attributes = ['userid' => $user_id];

        $request = new CUrl();
        $url = $this->getUrl(self::API_INVITE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['type'];
            });
        });
    }

    public function getOpenIdByUserIdTo($user_id, $agent_id = '')
    {
        $attributes = ['userid' => $user_id];
        if ($agent_id)
            $attributes['agent_id'] = $agent_id;

        $request = new CUrl();
        $url = $this->getUrl(self::API_CONVERT_TO_OPENID);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                unset($response['errcode'], $response['errmsg']);
                return $response;
            });
        });
    }

    public function getUserIdByOpenId($open_id)
    {
        $attributes = ['openid' => $open_id];

        $request = new CUrl();
        $url = $this->getUrl(self::API_CONVERT_TO_USERID);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['userid'];
            });
        });
    }



    ################################## Update ####################################

    public function setName($value)
    {
        return $this->setUpdateAttribute('name', $value);
    }

    public function setDepartment($value)
    {
        return $this->setUpdateAttribute('department', $value);
    }

    public function setPosition($value)
    {
        return $this->setUpdateAttribute('position', $value);
    }

    public function setGender($value)
    {
        return $this->setUpdateAttribute('gender', $value);
    }

    public function setEmail($value)
    {
        return $this->setUpdateAttribute('email', $value);
    }

    public function setWeixinId($value)
    {
        return $this->setUpdateAttribute('weixinid', $value);
    }

    public function setStatus($value)
    {
        return $this->setUpdateAttribute('enable', $value);
    }

    public function setAvatarMediaId($value)
    {
        return $this->setUpdateAttribute('avatar_mediaid', $value);
    }

    public function setExtAttr($value)
    {
        return $this->setUpdateAttribute('extattr', $value);
    }
}