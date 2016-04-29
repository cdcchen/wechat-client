<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/12
 * Time: 15:27
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\Client;

/**
 * Class BatchClient
 * @package cdcchen\wechat\qy\contact
 */
class BatchClient extends Client
{
    /**
     * batch job status: started
     */
    const STATUS_STARTED   = 1;
    /**
     * batch job status: doing
     */
    const STATUS_DOING     = 2;
    /**
     * batch job status: completed
     */
    const STATUS_COMPLETED = 3;

    /**
     * batch job type: synn_user
     */
    const TYPE_SYNC_USER     = 'sync_user';
    /**
     * batch job type: replace_user
     */
    const TYPE_REPLACE_USER  = 'replace_user';
    /**
     * batch job type: replace_party
     */
    const TYPE_REPLACE_PARTY = 'replace_party';

    /**
     * batch job action: new_user
     */
    const ACTION_NEW_USER    = 0x01;
    /**
     * batch job action: update_user
     */
    const ACTION_UPDATE_USER = 0x10;

    /**
     * batch job action: new_party
     */
    const ACTION_NEW_PARTY          = 0x0001;
    /**
     * batch job action: update_party_name
     */
    const ACTION_UPDATE_PARTY_NAME  = 0x0010;
    /**
     * batch job action: move_party
     */
    const ACTION_MOVE_PARTY         = 0x0100;
    /**
     * batch job action: update_party_order
     */
    const ACTION_UPDATE_PARTY_ORDER = 0x1000;

    /**
     * Api sync_user path
     */
    const API_SYNC_USER     = '/cgi-bin/batch/syncuser';
    /**
     * Api replace_user path
     */
    const API_REPLACE_USER  = '/cgi-bin/batch/replaceuser';
    /**
     * Api replace_party path
     */
    const API_REPLACE_PARTY = '/cgi-bin/batch/replacparty';
    /**
     * Api get_result path
     */
    const API_GET_RESULT = '/cgi-bin/batch/getresult';


    /**
     * @param string $media_id
     * @param string $url
     * @param string $token
     * @param string $encoding_aes_key
     * @return string
     */
    public function syncUsers($media_id, $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = ['media_id' => $media_id];

        return $this->request(self::API_SYNC_USER, $attributes, $url, $token, $encoding_aes_key);
    }

    /**
     * @param string $media_id
     * @param string $url
     * @param string $token
     * @param string $encoding_aes_key
     * @return string
     */
    public function replaceUsers($media_id, $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = ['media_id' => $media_id];

        return $this->request(self::API_REPLACE_USER, $attributes, $url, $token, $encoding_aes_key);
    }

    /**
     * @param string $media_id
     * @param string $url
     * @param string $token
     * @param string $encoding_aes_key
     * @return string
     */
    public function replaceParty($media_id, $url = '', $token = '', $encoding_aes_key = '')
    {
        $attributes = ['media_id' => $media_id];

        return $this->request(self::API_REPLACE_PARTY, $attributes, $url, $token, $encoding_aes_key);
    }

    /**
     * @param string $job_id
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getResult($job_id)
    {
        $url = $this->buildUrl(self::API_GET_RESULT);
        $request = HttpClient::get($url, ['jobid' => $job_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return $response->getData();
        });
    }


    /**
     * @param string $api_name
     * @param array $attributes
     * @param string $url
     * @param string $token
     * @param string $encoding_aes_key
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    protected function request($api_name, $attributes, $url, $token, $encoding_aes_key)
    {
        if ($url && $token && $encoding_aes_key) {
            $attributes['callback'] = static::buildCallback($url, $token, $encoding_aes_key);
        }

        $url = $this->buildUrl($api_name);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['jobid'];
        });
    }

    /**
     * @param string $url
     * @param string $token
     * @param string $encoding_aes_key
     * @return array
     */
    protected static function buildCallback($url, $token, $encoding_aes_key)
    {
        return [
            'url' => $url,
            'token' => $token,
            'encodingaeskey' => $encoding_aes_key,
        ];
    }
}