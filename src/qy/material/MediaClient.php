<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/20
 * Time: 下午3:29
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\ResponseException;
use cdcchen\wechat\qy\Client;

/**
 * Class MediaClient
 * @package cdcchen\wechat\qy\material
 */
class MediaClient extends Client
{
    const API_UPLOAD     = '/cgi-bin/media/upload';
    const API_UPLOAD_IMG = '/cgi-bin/media/uploadimg';
    const API_DOWNLOAD = '/cgi-bin/media/get';

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
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function upload($filename, $type, $postName = null)
    {
        $media = (new Media())->setFilename($filename, $postName);
        $url = $this->buildUrl(self::API_UPLOAD, ['type' => $type]);
        $request = HttpClient::post($url, $media->getFormData())
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
     * @return string
     */
    public function uploadFile($filename)
    {
        return $this->upload($filename, Media::TYPE_FILE);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function uploadVideo($filename)
    {
        return $this->upload($filename, Media::TYPE_VIDEO);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function uploadVoice($filename)
    {
        return $this->upload($filename, Media::TYPE_VOICE);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function uploadImage($filename)
    {
        return $this->upload($filename, Media::TYPE_IMAGE);
    }

    /**
     * @param string $filename
     * @param string $postName
     * @return mixed
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function uploadPhoto($filename, $postName = null)
    {
        $media = (new Media())->setFilename($filename, $postName);

        $url = $this->buildUrl(self::API_UPLOAD_IMG);
        $request = HttpClient::post($url, $media->getFormData())
                             ->addFile('upload_file', $media->getUploadFile())
                             ->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['url'];
        });
    }

    /**
     * @param string $media_id
     * @return null|string
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function download($media_id)
    {
        $url = $this->buildUrl(self::API_DOWNLOAD);
        $request = HttpClient::get($url, ['media_id' => $media_id]);
        $response = static::sendRequest($request);

        if ($response->getFormat() !== HttpRequest::FORMAT_JSON) {
            return $response->getContent();
        } else {
            $data = $response->getData();
            throw new ResponseException($data['errmsg'], $data['errcode']);
        }
    }
}