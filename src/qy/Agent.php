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

class Agent extends Client
{
    use UpdateAttributeTrait;

    const LOCATION_FLAG_DISABLED = 0;
    const LOCATION_FLAG_ON_ENTER = 1;
    const LOCATION_FLAG_ENABLED  = 2;

    const API_INFO   = '/cgi-bin/agent/get';
    const API_UPDATE = '/cgi-bin/agent/set';
    const API_LIST   = '/cgi-bin/agent/list';


    public function getAll()
    {
        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::get($url);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data['agentlist'];
            });
        });
    }

    public function query($agent_id)
    {
        $url = $this->buildUrl(self::API_INFO);
        $request = HttpClient::get($url, ['agentid' => $agent_id]);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data;
            });
        });
    }

    public function update($agent_id, $attributes = [])
    {
        $attributes = array_merge($this->_updateAttributes, $attributes);
        $attributes['agentid'] = $agent_id;
        if (count($attributes) <= 1) {
            throw new \InvalidArgumentException('There is no attributes need to be updated.');
        }

        $url = $this->buildUrl(self::API_UPDATE);
        $request = HttpClient::post($url, json_encode($attributes, 320))->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }

    public function setReportLocationFlag($flag)
    {
        return $this->setUpdateAttribute('report_location_flag', $flag);
    }

    public function setLogo($media_id)
    {
        return $this->setUpdateAttribute('logo_mediaid', $media_id);
    }

    public function setName($name)
    {
        return $this->setUpdateAttribute('name', $name);
    }

    public function setDescription($desc)
    {
        return $this->setUpdateAttribute('description', $desc);
    }

    public function setRedirectDomain($domain)
    {
        return $this->setUpdateAttribute('redirect_domain', $domain);
    }

    public function setIsReportUser($value)
    {
        return $this->setUpdateAttribute('isreportuser', $value);
    }

    public function setIsReportEnter($value)
    {
        return $this->setUpdateAttribute('isreportenter', $value);
    }

    public function setHomeUrl($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('The value is not invalid');
        }

        return $this->setUpdateAttribute('home_url', $value);
    }
}