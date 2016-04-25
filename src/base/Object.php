<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/12
 * Time: 15:18
 */

namespace cdcchen\wechat\base;


class Object
{
    protected static function checkRequiredAttributes($attributes, array $required_keys, array $one_required_keys = [])
    {
        foreach ($required_keys as $key) {
            if (!isset($attributes[$key]))
                throw new \InvalidArgumentException("Argument $key is required.");
        }

        $valid = false;
        foreach ($one_required_keys as $key) {
            if (isset($attributes[$key])) {
                $valid = true;
                break;
            }
        }
        if (!$valid)
            throw new \InvalidArgumentException('Arguments ' . join('/', $one_required_keys) . ' cannot at the same time is empty.');

        return true;
    }
}