<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午9:48
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\base\UpdateAttributeTrait;

/**
 * Class AgentClient
 * @package cdcchen\wechat\qy
 */
class AgentClient extends Client
{
    use UpdateAttributeTrait;

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
     * api info path
     */
    const API_INFO   = '/cgi-bin/agent/get';
    /**
     * api update path
     */
    const API_UPDATE = '/cgi-bin/agent/set';
    /**
     * api list path
     */
    const API_LIST = '/cgi-bin/agent/list';


    /**
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getAll()
    {
        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['agentlist'];
        });
    }

    /**
     * @param int $agent_id
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function query($agent_id)
    {
        $url = $this->buildUrl(self::API_INFO);
        $request = HttpClient::get($url, ['agentid' => $agent_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return $response->getData();
        });
    }

    /**
     * @param int 0$agent_id
     * @param array $attributes
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function update($agent_id, $attributes = [])
    {
        $attributes = array_merge($this->_updateAttributes, $attributes);
        $attributes['agentid'] = $agent_id;
        if (count($attributes) <= 1) {
            throw new \InvalidArgumentException('There is no attributes need to be updated.');
        }

        $url = $this->buildUrl(self::API_UPDATE);
        $request = HttpClient::post($url, json_encode($attributes, 320))->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $flag
     * @return $this
     */
    public function setReportLocationFlag($flag)
    {
        return $this->setUpdateAttribute('report_location_flag', $flag);
    }

    /**
     * @param string $media_id
     * @return $this
     */
    public function setLogo($media_id)
    {
        return $this->setUpdateAttribute('logo_mediaid', $media_id);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setUpdateAttribute('name', $name);
    }

    /**
     * @param string $desc
     * @return $this
     */
    public function setDescription($desc)
    {
        return $this->setUpdateAttribute('description', $desc);
    }

    /**
     * @param string $domain
     * @return $this
     */
    public function setRedirectDomain($domain)
    {
        return $this->setUpdateAttribute('redirect_domain', $domain);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setIsReportUser($value)
    {
        return $this->setUpdateAttribute('isreportuser', $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setIsReportEnter($value)
    {
        return $this->setUpdateAttribute('isreportenter', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setHomeUrl($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('The value is not invalid');
        }

        return $this->setUpdateAttribute('home_url', $value);
    }
}