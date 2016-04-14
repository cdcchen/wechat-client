<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午9:41
 */

namespace weixin\qy;


use phpplus\filesystem\FileHelper;
use phpplus\net\CUrl;

class Material extends Request
{
    const BATCH_GET_MAX_COUNT = 50;

    const API_UPLOAD = '/cgi-bin/material/add_material';
    const API_GET_ITEM = '/cgi-bin/material/get';
    const API_ADD_NEWS = '/cgi-bin/material/add_mpnews';
    const API_UPDATE_NEWS = '/cgi-bin/material/update_MPNEWS';
    const API_GET_COUNT = '/cgi-bin/material/get_count';
    const API_LIST = '/cgi-bin/material/batchget';
    const API_DELETE = '/cgi-bin/material/del';

    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';
    const TYPE_NEWS = 'mpnews';

    const SIZE_MIN = 5;
    const SIZE_IMAGE_MAX = 2048000;
    const SIZE_VOICE_MAX = 2048000;
    const SIZE_VIDEO_MAX = 10240000;
    const SIZE_FILE_MAX = 20480000;

    public function uploadFile($filename, $type)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_UPLOAD, ['type' => $type]);
        $media = static::makeMediaParams($filename);
        $request->post($url, $media, true);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['media_id'];
            });
        });
    }

    public function fetch($media_id, $agent_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_ITEM);
        $request->returnHeaders(true)
            ->get($url, ['media_id' => $media_id, 'agentid' => $agent_id]);

        return static::handleRequest($request, function(CUrl $request){
            $contentType = $request->getResponseHeaders('content-type');
            if (stripos($contentType, 'json') === false)
                return $request->getBody();
            else {
                return static::handleResponse($request, function($response){
                    return $response['mpnews'];
                });
            }
        });
    }

    public function createNews($agent_id, $news)
    {
        $attributes = [
            'agentid' => $agent_id,
            'mpnews' => $news,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_ADD_NEWS, $this->getAccessToken());
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['media_id'];
            });
        });
    }

    public function updateNews($agent_id, $media_id, $articles)
    {
        $attributes = [
            'agentid' => $agent_id,
            'media_id' => $media_id,
            'mpnews' => ['articles' => $articles],
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_UPDATE_NEWS, $this->getAccessToken());
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return true;
            });
        });
    }

    public function getCount($agent_id)
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_COUNT);
        $request->get($url, ['agentid' => $agent_id]);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                unset($response['errcode'], $response['errmsg']);
                return $response;
            });
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
        $url = $this->getUrl(self::API_LIST);

        $attributes = [
            'agentid' => $agent_id,
            'type' => $type,
            'count' => $count,
            'offset' => $offset,
        ];

        $request = new CUrl();
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                unset($response['errcode'], $response['errmsg']);
                return $response;
            });
        });
    }


    public function delete($agent_id, $media_id)
    {
        $url = $this->getUrl(self::API_DELETE);

        $attributes = [
            'agentid' => $agent_id,
            'media_id' => $media_id,
        ];

        $request = new CUrl();
        $request->get($url, $attributes);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                unset($response['errcode'], $response['errmsg']);
                return true;
            });
        });
    }

    protected static function makeMediaParams($filename)
    {
        $mimeType = FileHelper::getMimeType($filename, null, true);
        $file = new \CURLFile($filename, $mimeType);
        return [
            'upload_file' => $file,
            'filename' => $filename,
            'filelength' => filesize($filename),
            'content-type' => $mimeType,
        ];
    }
}