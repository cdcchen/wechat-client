<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午10:23
 */

namespace weixin\qy\contact;


use phpplus\net\CUrl;
use weixin\qy\Request;

class Department extends Request
{
    const API_CREATE = '/cgi-bin/department/create';
    const API_UPDATE = '/cgi-bin/department/update';
    const API_DELETE = '/cgi-bin/department/delete';
    const API_LIST = '/cgi-bin/department/list';


    public function select($id = null)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_LIST);
        $request->get($url, ['id' => $id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['department'];
            });
        });
    }

    public function create($name, $parent_id = 1, $order = 0, $id = 0)
    {
        $attributes = [
            'name' => $name,
            'parentid' => $parent_id,
        ];

        if ($order > 0) $attributes['order'] = $order;
        if ($id > 0) $attributes['id'] = $id;

        $request = new CUrl();
        $url = $this->getUrl(self::API_CREATE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['id'];
            });
        });
    }

    public function update($id, $name, $parent_id = 1, $order = 0)
    {
        $attributes = [
            'id' => $id,
            'name' => $name,
            'parentid' => $parent_id,
        ];

        if ($order > 0) $attributes['order'] = $order;

        $request = new CUrl();
        $url = $this->getUrl(self::API_UPDATE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function delete($id)
    {
        $attributes = ['id' => $id];

        $request = new CUrl();
        $url = $this->getUrl(self::API_DELETE);
        $request->get($url, $attributes);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }
}