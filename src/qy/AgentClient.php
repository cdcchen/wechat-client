<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午9:48
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\agent\AgentInfoRequest;
use cdcchen\wechat\qy\agent\AgentListRequest;
use cdcchen\wechat\qy\agent\AgentUpdateRequest;

/**
 * Class AgentClient
 * @package cdcchen\wechat\qy
 */
class AgentClient extends DefaultClient
{
    /**
     * 禁用地理位置上报
     */
    const LOCATION_FLAG_DISABLED = 0;
    /**
     * 启用进入应用时上报地理位置
     */
    const LOCATION_FLAG_ON_ENTER = 1;
    /**
     * 启用上报地理位置
     */
    const LOCATION_FLAG_ENABLED = 2;


    /**
     * @return array
     * @deprecated
     */
    public function getAll()
    {
        return $this->getList();
    }

    /**
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getList()
    {
        $request = new AgentListRequest();
        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['agentlist'];
        });
    }

    /**
     * @param int $id
     * @return array
     * @deprecated
     */
    public function query($id)
    {
        return $this->getInfo($id);
    }

    /**
     * @param int $id
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getInfo($id)
    {
        $request = (new AgentInfoRequest())->setId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return $response->getData();
        });
    }

    /**
     * @param AgentUpdateRequest $request
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function update(AgentUpdateRequest $request)
    {
        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }
}