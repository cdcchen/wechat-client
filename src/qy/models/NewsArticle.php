<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:26
 */

namespace cdcchen\wechat\qy\models;


class NewsArticle extends Base
{
    public $title;
    public $description;
    public $url;
    public $picUrl;

    public function attributesMap()
    {
        return ['title', '$description', 'url',
            'picUrl' => 'picurl',
        ];
    }
}