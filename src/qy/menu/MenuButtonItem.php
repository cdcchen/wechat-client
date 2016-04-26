<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 16:28
 */

namespace cdcchen\wechat\qy\menu;

use cdcchen\wechat\qy\base\BaseModel;


/**
 * Class MenuButtonItem
 * @package cdcchen\wechat\qy\models
 */
class MenuButtonItem extends BaseModel
{
    /**
     * 点击推事件
     */
    const TYPE_CLICK = 'click';
    /**
     * 跳转URL
     */
    const TYPE_VIEW = 'view';
    /**
     * 扫码推事件
     */
    const TYPE_SCANCODE_PUSH = 'scancode_push';
    /**
     * 扫码推事件且弹出“消息接收中”提示框
     */
    const TYPE_SCANCODE_WAITMSG = 'scancode_waitmsg';
    /**
     * 弹出系统拍照发图
     */
    const TYPE_PIC_SYSPHOTO = 'pic_sysphoto';
    /**
     * 弹出拍照或者相册发图
     */
    const TYPE_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';
    /**
     * 弹出微信相册发图器
     */
    const TYPE_PIC_WEIXIN = 'pic_weixin';
    /**
     * 弹出地理位置选择器
     */
    const TYPE_LOCATION_SELECT = 'location_select';

    public $type;
    public $name;
    public $key = false;
    public $url = false;
    public $subButton = false;

    public function attributesMap()
    {
        return [
            'type',
            'name',
            'key',
            'url',
            'subButton' => 'sub_button'
        ];
    }

    public function addSubButton(self $item)
    {
        $this->subButton[] = $item;
        return $this;
    }

    public function setSubButtons(array $items)
    {
        $this->subButton = $items;
        return $this;
    }

}