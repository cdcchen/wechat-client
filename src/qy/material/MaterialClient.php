<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午9:41
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\Client;

class MaterialClient extends Client
{
    const BATCH_GET_MAX_COUNT = 50;

    const API_UPLOAD      = '/cgi-bin/material/add_material';
    const API_GET_ITEM    = '/cgi-bin/material/get';
    const API_ADD_NEWS    = '/cgi-bin/material/add_mpnews';
    const API_UPDATE_NEWS = '/cgi-bin/material/update_MPNEWS';
    const API_GET_COUNT   = '/cgi-bin/material/get_count';
    const API_LIST        = '/cgi-bin/material/batchget';
    const API_DELETE      = '/cgi-bin/material/del';

    const SIZE_MIN       = 5;
    const SIZE_IMAGE_MAX = 2048000;
    const SIZE_VOICE_MAX = 2048000;
    const SIZE_VIDEO_MAX = 10240000;
    const SIZE_FILE_MAX  = 20480000;

    /**
     * @param string $filename
     * @param string $type
     * @param string|null $postName
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function upload($filename, $type, $postName = null)
    {
        $media = (new Media())->setFilename($filename, $postName);

        $url = $this->buildUrl(self::API_UPLOAD, ['type' => $type]);
        $request = HttpClient::post($url, $media->getFormData(), true)
                             ->addFile('upload_file', $media->getUploadFile())
                             ->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['media_id'];
        });
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadFile($filename, $postName = null)
    {
        return $this->upload($filename, Media::TYPE_FILE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadImage($filename, $postName = null)
    {
        return $this->upload($filename, Media::TYPE_IMAGE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadVoice($filename, $postName = null)
    {
        return $this->upload($filename, Media::TYPE_VOICE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadVideo($filename, $postName = null)
    {
        return $this->upload($filename, Media::TYPE_VIDEO, $postName);
    }

    /**
     * @param int $agent_id
     * @param array $news
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function uploadNews($agent_id, $news)
    {
        $attributes = [
            'agentid' => $agent_id,
            'mpnews' => $news,
        ];

        $url = $this->buildUrl(self::API_ADD_NEWS, $this->getAccessToken());
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['media_id'];
        });
    }

    /**
     * @param int $agent_id
     * @param string $media_id
     * @param array $articles
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function updateNews($agent_id, $media_id, $articles)
    {
        $attributes = [
            'agentid' => $agent_id,
            'media_id' => $media_id,
            'mpnews' => ['articles' => $articles],
        ];

        $url = $this->buildUrl(self::API_UPDATE_NEWS, $this->getAccessToken());
        $request = HttpClient::post($url, $attributes);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $media_id
     * @param int $agent_id
     * @return mixed|null|string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function fetch($media_id, $agent_id)
    {
        $url = $this->buildUrl(self::API_GET_ITEM);
        $request = HttpClient::get($url, ['media_id' => $media_id, 'agentid' => $agent_id]);
        $response = static::sendRequest($request);

        if ($response->getFormat() !== HttpRequest::FORMAT_JSON) {
            return $response->getContent();
        } else {
            return static::handleResponse($response, function (HttpResponse $response) {
                $data = $response->getData();
                return $data['mpnews'];
            });
        }
    }

    /**
     * @param int $agent_id
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getCount($agent_id)
    {
        $url = $this->buildUrl(self::API_GET_COUNT);
        $request = HttpClient::get($url, ['agentid' => $agent_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @param int $agent_id
     * @param string $type
     * @param int $count
     * @param int $offset
     * @return array
     * @throws \ErrorException
     */
    public function query($agent_id, $type, $count, $offset = 0)
    {
        $attributes = [
            'agentid' => $agent_id,
            'type' => $type,
            'count' => $count,
            'offset' => $offset,
        ];

        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }


    /**
     * @param int $agent_id
     * @param string $media_id
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($agent_id, $media_id)
    {
        $url = $this->buildUrl(self::API_DELETE);

        $attributes = [
            'agentid' => $agent_id,
            'media_id' => $media_id,
        ];

        $request = HttpClient::get($url, $attributes);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return true;
        });
    }
}