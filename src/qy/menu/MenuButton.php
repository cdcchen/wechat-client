<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/4/26
 * Time: 16:36
 */

namespace cdcchen\wechat\qy\menu;


class MenuButton
{
    /**
     * @var MenuButtonItem[]
     */
    private $_buttons = [];

    public function addButton($item)
    {
        $this->_buttons[] = $item;
        return $this;
    }

    /**
     * @return array
     */
    public function build()
    {
        $buttons = $this->format($this->_buttons);
        return ['button' => $buttons];
    }

    private function format(array $items)
    {
        $buttons = [];
        foreach ($items as $item) {
            if (!($item instanceof MenuButtonItem)) {
                throw new \InvalidArgumentException('Buttons type is must be MenuButtonItem array');
            }

            $button = $item->toArray();
            if (is_array($item->subButton)) {
                $button['sub_button'] = $this->format($item->subButton);
            }
            $buttons[] = $button;
        }

        return $buttons;
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
        $button->name = $name;
        $button->type = $type;
        $button->key = $key ?: false;
        $button->url = $url ?: false;

        return $button;
    }
}