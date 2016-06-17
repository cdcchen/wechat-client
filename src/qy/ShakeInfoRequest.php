<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 22:25
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class ShakeInfoRequest
 * @package cdcchen\wechat\qy
 */
class ShakeInfoRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/shakearound/getshakeinfo';

    /**
     * @param string $value
     * @return $this
     */
    public function setTicket($value)
    {
        return $this->setData('ticket', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['ticket'];
    }
}