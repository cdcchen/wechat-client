<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 23:35
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\wechat\qy\base\BaseModel;
use phpplus\filesystem\FileHelper;

class Media extends BaseModel
{
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE  = 'file';
    const TYPE_NEWS  = 'mpnews';

    public function setFilename($filename)
    {
        if (!is_file($filename)) {
            throw new \InvalidArgumentException("$filename is not a file.");
        }

        $mimeType = FileHelper::getMimeType($filename, null, true);
        $file = new \CURLFile($filename, $mimeType, basename($filename));
        $attributes = [
            'upload_file' => $file,
            'filename' => $filename,
            'filelength' => filesize($filename),
            'content-type' => $mimeType,
        ];
        return $this->setAttributes($attributes);
    }

    public function getFormData($includeCurlFile = false)
    {
        $data = [
            'filename' =>  $this->getAttribute('filename'),
            'filelength' => $this->getAttribute('filelength'),
            'content-type' => $this->getAttribute('content-type'),
        ];

        if ($includeCurlFile) {
            $data['upload_file'] = $this->getAttribute('upload_file');
        }

        return $data;
    }

    public function getUploadFile()
    {
        return $this->getAttribute('upload_file');
    }

    protected function fields()
    {
        return ['upload_file', 'filename', 'filelength', 'content-type'];
    }


}