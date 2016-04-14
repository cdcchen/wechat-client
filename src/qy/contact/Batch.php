<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/12
 * Time: 15:27
 */

namespace weixin\qy\contact;


use phpplus\net\CUrl;
use weixin\qy\Request;

class Batch extends Request
{
    const TYPE_INVITE_USER      = 'invite_user';
    const TYPE_SYNC_USER        = 'sync_user';
    const TYPE_REPLACE_USER     = 'replace_user';
    const TYPE_REPLACE_PARTY    = 'replace_party';

    const USER_ACTION_NEW       = 0x01;
    const USER_ACTION_UPDATE    = 0x10;

    const PARTY_ACTION_NEW          = 0x0001;
    const PARTY_ACTION_UPDATE_NAME  = 0x0010;
    const PARTY_ACTION_MOVIE        = 0x0100;
    const PARTY_ACTION_UPDATE_ORDER = 0x1000;

    const API_INVITE_USER       = '/cgi-bin/batch/inviteuser';
    const API_SYNC_USER         = '/cgi-bin/batch/syncuser';
    const API_REPLACE_USER      = '/cgi-bin/batch/replaceuser';
    const API_REPLACE_PARTY     = '/cgi-bin/batch/replacparty';
    const API_GET_RESULT        = '/cgi-bin/batch/getresult';

    public function inviteUsers($to_user = [], $to_party = [], $to_tag = [], $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = [];
        if ($to_user)   $attributes['touser'] = join('|', $to_user);
        if ($to_party)  $attributes['toparty'] = join('|', $to_party);
        if ($to_tag)    $attributes['totag'] = join('|', $to_tag);

        return $this->request(self::API_INVITE_USER, $attributes, $url, $token, $encoding_aes_key);
    }

    public function syncUsers($media_id, $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = ['media_id' => $media_id];

        return $this->request(self::API_SYNC_USER, $attributes, $url, $token, $encoding_aes_key);
    }

    public function replaceUsers($media_id, $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = ['media_id' => $media_id];

        return $this->request(self::API_REPLACE_USER, $attributes, $url, $token, $encoding_aes_key);
    }

    public function replaceParty($media_id, $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = ['media_id' => $media_id];

        return $this->request(self::API_REPLACE_PARTY, $attributes, $url, $token, $encoding_aes_key);
    }

    public function getResult($job_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_RESULT);
        $request->get($url, ['jobid' => $job_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response;
            });
        });
    }



    protected function request($api_name, $attributes, $url, $token, $encoding_aes_key)
    {
        if ($url && $token && $encoding_aes_key)
            $attributes['callback'] = static::buildCallback($url, $token, $encoding_aes_key);

        $request = new CUrl();
        $url = $this->getUrl($api_name);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['jobid'];
            });
        });
    }

    protected static function buildCallback($url, $token, $encoding_aes_key)
    {
        return [
            'url'               => $url,
            'token'             => $token,
            'encodingaeskey'    => $encoding_aes_key,
        ];
    }
}