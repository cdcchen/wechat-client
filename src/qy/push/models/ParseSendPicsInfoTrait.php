<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/24
 * Time: 下午5:38
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class ParseSendPicsInfoTrait
 * @package cdcchen\wechat\qy\push\models
 */
trait ParseSendPicsInfoTrait
{
    /**
     * @return int
     */
    public function getCount()
    {
        return $this->getSendPicsInfo('Count');
    }

    /**
     * @return array
     */
    public function getPicList()
    {
        $items = $this->getSendPicsInfo('PicList');
        if (empty($items)) {
            return [];
        }

        $pics = [];
        foreach ($items as $item) {
            $pics[] = ['md5Sum' => $item['PicMd5Sum']];
        }

        return $pics;
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function getSendPicsInfo($name)
    {
        $info = $this->get('SendPicsInfo');
        return isset($info[$name]) ? $info[$name] : null;
    }
}