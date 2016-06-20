<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午9:41
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\DefaultClient;
use cdcchen\wechat\qy\material\MaterialCountRequest;
use cdcchen\wechat\qy\material\MaterialDeleteRequest;
use cdcchen\wechat\qy\material\MaterialInfoRequest;
use cdcchen\wechat\qy\material\MaterialListRequest;
use cdcchen\wechat\qy\material\MaterialUploadRequest;
use cdcchen\wechat\qy\material\Media;
use cdcchen\wechat\qy\material\UploadMPNewsRequest;

class MaterialClient extends DefaultClient
{
    const BATCH_GET_MAX_COUNT = 50;

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
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function upload($filename, $type, $postName = null)
    {
        $media = (new Media())->setFilename($filename, $postName);
        $request = (new MaterialUploadRequest())->setType($type)->setMedia($media);

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
        static::validateFileSize(filesize($filename), MediaClient::MAX_FILE_SIZE);
        return $this->upload($filename, Media::TYPE_FILE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadVideo($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), MediaClient::MAX_VIDEO_SIZE);
        return $this->upload($filename, Media::TYPE_VIDEO, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadVoice($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), MediaClient::MAX_VOICE_SIZE);
        return $this->upload($filename, Media::TYPE_VOICE, $postName);
    }

    /**
     * @param string $filename
     * @param string|null $postName
     * @return string
     */
    public function uploadImage($filename, $postName = null)
    {
        static::validateFileSize(filesize($filename), MediaClient::MAX_IMAGE_SIZE);
        return $this->upload($filename, Media::TYPE_IMAGE, $postName);
    }

    /**
     * @param int $agentId
     * @param \cdcchen\wechat\qy\material\MPNewsArticle[] $articles
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function uploadNews($agentId, $articles)
    {
        $request = (new UploadMPNewsRequest())->setAgentId($agentId)
                                              ->setArticles($articles);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['media_id'];
        });
    }

    /**
     * @param int $agentId
     * @param string $mediaId
     * @param array $articles
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function updateMPNews($agentId, $mediaId, $articles)
    {
        $request = (new UploadMPNewsRequest())->setAgentId($agentId)
                                              ->setMediaId($mediaId)
                                              ->setArticles($articles);


        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $mediaId
     * @param int $agentId
     * @return mixed|null|string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getInfo($mediaId, $agentId)
    {
        $request = (new MaterialInfoRequest())->setMediaId($mediaId)->setAgentId($agentId);
        $response = $this->sendRequest($request);

        if ($response->getFormat() === HttpRequest::FORMAT_JSON) {
            $data = $response->getData();
            return $data['mpnews']['articles'];
        };

        return $response->getContent();
    }

    /**
     * @param int $agentId
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getCount($agentId)
    {
        $request = (new MaterialCountRequest())->setAgentId($agentId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @param int $agentId
     * @param string $type
     * @param int $count
     * @param int $offset
     * @return array
     * @throws \ErrorException
     */
    public function query($agentId, $type, $count, $offset = 0)
    {
        $request = (new MaterialListRequest())->setAgentId($agentId)
                                              ->setType($type)
                                              ->setOffset($offset)
                                              ->setCount($count);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }


    /**
     * @param int $agentId
     * @param string $mediaId
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($agentId, $mediaId)
    {
        $request = (new MaterialDeleteRequest())->setAgentId($agentId)->setMediaId($mediaId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
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