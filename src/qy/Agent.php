<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午9:48
 */

namespace weixin\qy;


use phpplus\net\CUrl;
use phpplus\net\UrlHelper;
use weixin\qy\base\UpdateTrait;

class Agent extends Request
{
    use UpdateTrait;

    const LOCATION_FLAG_DISABLED = 0;
    const LOCATION_FLAG_ON_ENTER = 1;
    const LOCATION_FLAG_ENABLED = 2;

    const API_INFO = '/cgi-bin/agent/get';
    const API_UPDATE = '/cgi-bin/agent/set';
    const API_LIST = '/cgi-bin/agent/list';


    public function getAll()
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_LIST);
        $request->get($url);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['agentlist'];
            });
        });
    }

    public function select($agent_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_INFO);
        $request->get($url, ['agentid' => $agent_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response;
            });
        });
    }

    public function update($agent_id, $attributes = [])
    {
        $attributes = array_merge($this->_updateAttributes, $attributes);
        $attributes['agentid'] = $agent_id;
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
        if (!UrlHelper::isUrl($value))
            throw new \InvalidArgumentException('The value is not invalid');

        return $this->setUpdateAttribute('home_url', $value);
    }
}