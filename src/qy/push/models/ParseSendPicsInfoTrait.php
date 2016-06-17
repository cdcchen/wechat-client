<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/24
 * Time: 下午5:38
 */

namespace cdcchen\wechat\qy\push\models;


trait ParseSendPicsInfoTrait
{
    /**
     * @return array
     */
    private function parsePicInfo()
    {
        /* @var \SimpleXMLElement $list */
        $list = $this->_xml->SendPicsInfo->PicList;

        $pics = [];
        if ($list->count() > 0) {
            $items = $list->children();
            foreach ($items as $item) {
                $pics[] = ['md5Sum' => (string)$item->PicMd5Sum];
            }
        }

        return $pics;
    }
}