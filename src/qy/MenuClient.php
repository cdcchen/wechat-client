<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午1:59
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\DefaultClient;
use cdcchen\wechat\qy\menu\MenuButton;
use cdcchen\wechat\qy\menu\MenuCreateRequest;
use cdcchen\wechat\qy\menu\MenuDeleteRequest;
use cdcchen\wechat\qy\menu\MenuFetchRequest;

/**
 * Class MenuClient
 * @package cdcchen\wechat\qy\menu
 */
class MenuClient extends DefaultClient
{
    /**
     * @param int $agentId
     * @param MenuButton $button
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function create($agentId, MenuButton $button)
    {
        $items = $button->toArray();
        $request = (new MenuCreateRequest())->setAgentId($agentId)->setButton($items);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $agentId
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($agentId)
    {
        $request = (new MenuDeleteRequest())->setAgentId($agentId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $agentId
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function fetch($agentId)
    {
        $request = (new MenuFetchRequest())->setAgentId($agentId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['menu'];
        });
    }
}