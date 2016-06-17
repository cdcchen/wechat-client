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
 * Class MenuCreateRequest
 * @package cdcchen\wechat\qy\menu
 */
class MenuCreateRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/menu/create';

    /**
     * @param int $id
     * @return $this
     */
    public function setAgentId($id)
    {
        return $this->setQueryParam('agentid', $id);
    }

    /**
     * @param array $button
     * @return $this
     */
    public function setButton(array $button)
    {
        return $this->setData('button', $button);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid', 'button'];
    }
}