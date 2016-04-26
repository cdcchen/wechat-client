<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:27
 */

namespace cdcchen\wechat\qy\models;


abstract class Base
{
    abstract public function attributesMap();

    public function buildAttributes()
    {
        $attributes = [];
        foreach ($this->attributesMap() as $key => $attr) {
            if (is_int($key))
                $attributes[$attr] = $this->$attr;
            elseif (is_string($key))
                $attributes[$attr] = $this->$key;
            else
                throw new \Exception('Key is not valid in attributes map.');
        }

        return $attributes;
    }
}