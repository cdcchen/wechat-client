<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:35
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\filesystem\FileHelper;
use cdcchen\wechat\qy\base\BaseModel;

/**
 * Class Media
 * @package cdcchen\wechat\qy\material
 */
class Media extends BaseModel
{
    /**
     * image type
     */
    const TYPE_IMAGE = 'image';
    /**
     * voice type
     */
    const TYPE_VOICE = 'voice';
    /**
     * video type
     */
    const TYPE_VIDEO = 'video';
    /**
     * file type
     */
    const TYPE_FILE = 'file';
    /**
     * file type
     */
    const TYPE_NEWS = 'mpnews';

    /**
     * @param string $filename
     * @param string $postName
     * @return $this
     * @throws \Exception
     */
    public function setFilename($filename, $postName = null)
    {
        if (!is_file($filename)) {
            throw new \InvalidArgumentException("$filename is not a file.");
        }

        $mimeType = FileHelper::getMimeType($filename, null, false);
        if (empty($postName)) {
            $postName = trim(basename($filename), '.');
        }
        $file = new \CURLFile($filename, $mimeType, $postName);
        $attributes = [
            'upload_file' => $file,
            'filename' => $postName,
            'filelength' => filesize($filename),
            'content-type' => $mimeType,
        ];
        return $this->setAttributes($attributes);
    }

    /**
     * @param bool $includeCurlFile
     * @return array
     */
    public function getFormData($includeCurlFile = false)
    {
        $data = [
            'filename' => $this->getAttribute('filename'),
            'filelength' => $this->getAttribute('filelength'),
            'content-type' => $this->getAttribute('content-type'),
        ];

        if ($includeCurlFile) {
            $data['upload_file'] = $this->getAttribute('upload_file');
        }

        return $data;
    }

    /**
     * @return array|bool|string
     */
    public function getUploadFile()
    {
        return $this->getAttribute('upload_file');
    }

    /**
     * @return array
     */
    protected function fields()
    {
        return ['upload_file', 'filename', 'filelength', 'content-type'];
    }


}