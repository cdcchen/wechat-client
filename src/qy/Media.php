<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/20
 * Time: 下午3:29
 */

namespace weixin\qy;


use phpplus\filesystem\FileHelper;
use phpplus\net\CUrl;
use weixin\base\ResponseException;

class Media extends Request
{
    const API_UPLOAD = '/cgi-bin/media/upload';
    const API_UPLOAD_IMG = '/cgi-bin/media/uploadimg';
    const API_DOWNLOAD = '/cgi-bin/media/get';

    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';

    const SIZE_MIN = 5;
    const SIZE_IMAGE_MAX = 2048000;
    const SIZE_VOICE_MAX = 2048000;
    const SIZE_VIDEO_MAX = 10240000;
    const SIZE_FILE_MAX = 20480000;

    public function upload($filename, $type)
    {
        $url = $this->getUrl(self::API_UPLOAD, ['type' => $type]);
        $media = static::makeMediaParams($filename);

        $request = new CUrl();
        $request->post($url, $media, true);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['media_id'];
            });
        });
    }

    public function uploadImage($filename)
    {
        $url = $this->getUrl(self::API_UPLOAD_IMG);
        $media = static::makeMediaParams($filename);

        $request = new CUrl();
        $request->post($url, $media, true);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['url'];
            });
        });
    }

    public function download($media_id)
    {
        $url = $this->getUrl(self::API_DOWNLOAD);

        $request = new CUrl();
        $request->returnHeaders(true)->get($url, ['media_id' => $media_id]);

        return static::handleRequest($request, function(CUrl $request){
            $contentType = $request->getResponseHeaders('content-type');
            if (stripos($contentType, 'json') === false) {
                return $request->getBody();
            }
            else {
                $response = $request->getJsonData();
                throw new ResponseException($response['errmsg'], $response['errcode']);
            }
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