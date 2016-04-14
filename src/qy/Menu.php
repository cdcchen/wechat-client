<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午1:59
 */

namespace weixin\qy;


use phpplus\net\CUrl;

class Menu extends Request
{
    const API_CREATE = '/cgi-bin/menu/create';
    const API_DELETE = '/cgi-bin/menu/delete';
    const API_LIST = '/cgi-bin/menu/get';

    public function create($agent_id, $attributes)
    {
        if (!isset($attributes['button']))
            $attributes = ['button' => $attributes];

        $url = $this->getUrl(self::API_CREATE, ['agentid' => $agent_id]);

        $request = new CUrl();
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function delete($agent_id)
    {
        $url = $this->getUrl(self::API_DELETE);

        $request = new CUrl();
        $request->post($url, ['agentid' => $agent_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function select($agent_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_LIST);
        $request->get($url, ['agentid' => $agent_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                unset($response['errcode'], $response['errmsg']);
                return $response;
            });
        });
    }
}