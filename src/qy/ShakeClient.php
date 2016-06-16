<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/9
 * Time: 22:15
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;

/**
 * Class ShakeClient
 * @package cdcchen\wechat\qy
 */
class ShakeClient extends DefaultClient
{
    /**
     * @param $ticket
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getInfo($ticket)
    {
        $client = new DefaultClient();
        $request = (new ShakeInfoRequest())->setTicket($ticket);
        return $client->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['data'];
        });
    }
}