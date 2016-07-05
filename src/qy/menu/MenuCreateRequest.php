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
     * @param MenuButton $button
     * @return $this
     */
    public function setButton(MenuButton $button)
    {
        if (!$button->hasButtons()) {
            throw new \InvalidArgumentException('No buttons found.');
        }

        $buttonArray = $button->toArray();
        $buttons = $buttonArray['button'];
        return $this->setData('button', $buttons);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['agentid', 'button'];
    }
}