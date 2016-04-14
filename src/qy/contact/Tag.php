<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午2:57
 */

namespace weixin\qy\contact;


use phpplus\net\CUrl;
use weixin\base\ResponseException;
use weixin\qy\Request;

class Tag extends Request
{
    const API_CREATE = '/cgi-bin/tag/create';
    const API_UPDATE = '/cgi-bin/tag/update';
    const API_DELETE = '/cgi-bin/tag/delete';
    const API_LIST = '/cgi-bin/tag/list';
    const API_GET_USERS = '/cgi-bin/tag/get';
    const API_ADD_USERS = '/cgi-bin/tag/addtagusers';
    const API_DELETE_USERS = '/cgi-bin/tag/deltagusers';

    
    public function getAll()
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_LIST);
        $request->get($url);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['taglist'];
            });
        });
    }

    public function create($name, $id = 0)
    {
        $attributes = ['tagname' => $name];
        if ($id > 0) $attributes['tagid'] = $id;

        $request = new CUrl();
        $url = $this->getUrl(self::API_CREATE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['tagid'];
            });
        });
    }

    public function update($id, $name)
    {
        $attributes = [
            'tagid' => $id,
            'tagname' => $name,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_UPDATE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['data'];
            });
        });
    }

    public function delete($id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_DELETE);
        $request->get($url, ['tagid' => $id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function getUsers($id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_USERS);
        $request->get($url, ['tagid' => $id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['userlist'];
            });
        });
    }

    public function addUsers($id, array $user_list = [], array $party_list = [])
    {
        if (empty($user_list) && empty($party_list))
            throw new \InvalidArgumentException('$user_list and $party_list can\'t at the same time is empty.');

        $attributes = [
            'tagid' => $id,
            'userlist' => $user_list,
            'partylist' => $party_list,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_ADD_USERS);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                if ($response['invalidlist'] || $response['invalidparty'])
                    throw new ResponseException($response['errmsg'], $response['invalidlist'] . $response['invalidparty']);
                else
                    return true;
            });
        });
    }

    public function deleteUsers($id, array $user_list = [], array $party_list = [])
    {
        if (empty($user_list) && empty($party_list))
            throw new \InvalidArgumentException('$user_list and $party_list can\'t at the same time is empty.');

        $attributes = [
            'tagid' => $id,
            'userlist' => $user_list,
            'partylist' => $party_list,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_DELETE_USERS);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                $invalid = [
                    'invalidlist' => $response['invalidlist'],
                    'invalidparty' => $response['invalidparty'],
                ];
                $invalid = array_filter($invalid);

                if ($invalid) {
                    $invalidText = join('；', $invalid);
                    throw new ResponseException($response['errmsg'] . $invalidText);
                }
                else
                    return true;
            });
        });
    }
}