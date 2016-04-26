<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:27
 */

namespace cdcchen\wechat\qy\base;


abstract class BaseModel
{
    abstract public function attributesMap();

    protected function buildAttributes()
    {
        $attributes = [];
        foreach ($this->attributesMap() as $key => $attr) {
            if (is_int($key)) {
                $value = $this->$attr;
            } elseif (is_string($key)) {
                $value = $this->$key;
            } else {
                throw new \Exception('Key is not valid in attributes map.');
            }

            if ($value !== false) {
                $attributes[$attr] = $value;
            }
        }

        return $attributes;
    }

    public function toArray()
    {
        return $this->buildAttributes();
    }
}