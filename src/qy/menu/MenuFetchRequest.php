<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 15:48
 */

namespace cdcchen\wechat\qy\menu;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class MenuFetchRequest
 * @package cdcchen\wechat\qy\menu
 */
class MenuFetchRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/menu/get';

    /**
     * @param int $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setQueryParam('agentid', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid'];
    }
}