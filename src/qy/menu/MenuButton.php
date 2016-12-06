<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 16:36
 */

namespace cdcchen\wechat\qy\menu;


use cdcchen\wechat\qy\base\BaseModel;

/**
 * Class MenuButton
 * @package cdcchen\wechat\qy\menu
 */
class MenuButton extends BaseModel
{
    /**
     * @var array
     */
    private $_buttons = [];

    /**
     * @param array $data
     * @return static
     */
    public static function load($data)
    {
        $button = new static();
        $buttons = $data['button'];
        $button->setButtons(static::parseButtons($buttons));

        return $button;
    }

    /**
     * @param array $buttons
     * @return array
     */
    protected static function parseButtons($buttons)
    {
        foreach ((array)$buttons as $key => $button) {
            if (!empty($button['sub_button'])) {
                $button['sub_button'] = static::parseButtons($button['sub_button']);
            } elseif (isset($button['sub_button'])) {
                unset($button['sub_button']);
            }
            $buttons[$key] = new MenuButtonItem($button);
        }

        return $buttons;
    }

    /**
     * @param array $buttons
     * @return $this
     */
    public function setButtons(array $buttons)
    {
        return $this->setAttribute('button', $buttons);
    }

    /**
     * @param MenuButtonItem $button
     * @return $this
     */
    public function addButton(MenuButtonItem $button)
    {
        $this->_buttons[] = $button;
        return $this->setAttribute('button', $this->_buttons);
    }

    /**
     * @return array|bool|string
     */
    public function getButtons()
    {
        return $this->getAttribute('button');
    }

    /**
     * @return int
     */
    public function getButtonsCount()
    {
        $buttons = $this->getButtons();
        return count($buttons);
    }

    /**
     * @return bool
     */
    public function hasButtons()
    {
        return $this->getButtonsCount() > 0;
    }

    /**
     * @param string $type
     * @param string $name
     * @param string|bool|null $key
     * @param string|bool|null $url
     * @return MenuButtonItem
     */
    public static function createButtonItem($type, $name, $key, $url)
    {
        if (empty($key) && empty($url)) {
            throw new \InvalidArgumentException('Key and Url cannot at the same time is empty.');
        }

        $button = new MenuButtonItem();
        $button->setName($name)->setType($type)->setKey($key)->setUrl($url);

        return $button;
    }

    /**
     * @return array
     */
    protected function fields()
    {
        return ['button'];
    }
}