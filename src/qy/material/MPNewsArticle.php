<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:26
 */

namespace cdcchen\wechat\qy\models;


use cdcchen\wechat\qy\base\BaseModel;

class MPNewsArticle extends BaseModel
{
    public $title;
    public $thumbMediaId;
    public $author;
    public $contentSourceUrl;
    public $content;
    public $digest;
    public $showCoverPic;

    public function attributesMap()
    {
        return [
            'title',
            'author',
            'content',
            'digest',
            'thumbMediaId' => 'thumb_media_id',
            'contentSourceUrl' => 'content_source_url',
            'showCoverPic' => 'show_cover_pic',
        ];
    }
}