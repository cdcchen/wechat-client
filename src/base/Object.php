<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/12
 * Time: 15:18
 */

namespace cdcchen\wechat\base;


/**
 * Class Object
 * @package cdcchen\wechat\base
 */
class Object
{
    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }
}