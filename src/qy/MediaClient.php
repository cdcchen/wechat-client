<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/20
 * Time: 下午3:29
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\ResponseException;
use cdcchen\wechat\qy\base\Media;
use cdcchen\wechat\qy\material\MediaDownloadRequest;
use cdcchen\wechat\qy\material\MediaUploadRequest;
use cdcchen\wechat\qy\material\UploadNewsImageRequest;

/**
 * Class MediaClient
 * @package cdcchen\wechat\qy\material
 */
class MediaClient extends DefaultClient
{
    const SIZE_MIN       = 5;
    const MAX_IMAGE_SIZE = 2048000;
    const MAX_VOICE_SIZE = 2048000;
    const MAX_VIDEO_SIZE = 10240000;
    const MAX_FILE_SIZE  = 20480000;

    /**
     * @param string $filename
     * @param string $type
     * @param string|null $postName
     * @return string
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function upload($filename, $type, $postName = null)
    {
        $media = (new Media())->setFilename($filename, $postName);
        $request = (new MediaUploadRequest())->setType($type)->setMedia($media);

        return $this->sendRequest($request, function (HttpResponse $response) {
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
        static::validateFileSize(filesize($filename), self::MAX_FILE_SIZE);
        return $this->upload($filename, Media::TYPE_FILE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadVideo($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), self::MAX_VIDEO_SIZE);
        return $this->upload($filename, Media::TYPE_VIDEO, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadVoice($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), self::MAX_VOICE_SIZE);
        return $this->upload($filename, Media::TYPE_VOICE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadImage($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), self::MAX_IMAGE_SIZE);
        return $this->upload($filename, Media::TYPE_IMAGE, $postName);
    }

    /**
     * @param string $filename
     * @param string $postName
     * @return string
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function uploadNewsImage($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), self::MAX_IMAGE_SIZE);

        $media = (new Media())->setFilename($filename, $postName);
        $request = (new UploadNewsImageRequest())->setMedia($media);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['url'];
        });
    }

    /**
     * @param string $mediaId
     * @return null|string
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function download($mediaId)
    {
        $request = (new MediaDownloadRequest())->setMediaId($mediaId);
        $response = $this->sendRequest($request);

        if ($response->getFormat() === HttpRequest::FORMAT_JSON) {
            $data = $response->getData();
            throw new ResponseException($data['errmsg'], $data['errcode']);
        }

        return $response->getContent();
    }

    /**
     * @param int $size
     * @param int $limit
     */
    private static function validateFileSize($size, $limit)
    {
        if ($size > $limit) {
            throw new \InvalidArgumentException("Upload media file size ($size) is too big, Maximum $limit.");
        }
    }
}