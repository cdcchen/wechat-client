<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/9
 * Time: 22:15
 */

namespace weixin\qy;


use phpplus\net\CUrl;

class Shake extends Request
{
    const API_GET_SHAKE_INFO = '/cgi-bin/shakearound/getshakeinfo';

    public function getInfo($ticket)
    {
        $attributes = ['ticket' => $ticket];

        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_SHAKE_INFO);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['data'];
            });
        });
    }
}