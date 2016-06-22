<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class ScanCodeWaitMsgEvent
 * @package cdcchen\wechat\qy\push\models
 */
class ScanCodeWaitMsgEvent extends EventMessage
{
    use EventKeyTrait;

    /**
     * @return string
     */
    public function getScanType()
    {
        return $this->getScanCodeInfo('ScanType');
    }

    /**
     * @return string
     */
    public function getScanResult()
    {
        return $this->getScanCodeInfo('ScanResult');
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function getScanCodeInfo($name)
    {
        $info = $this->get('ScanCodeInfo');
        if ($info === null) {
            return null;
        }

        return isset($info[$name]) ? $info[$name] : null;
    }
}