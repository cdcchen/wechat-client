<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:10
 */

namespace weixin\qy\base;


trait UpdateTrait
{
    protected $_updateAttributes = [];

    public function setUpdateAttribute($attribute, $value)
    {
        $this->_updateAttributes[$attribute] = $value;
        return $this;
    }

    public function resetUpdateAttributes()
    {
        $this->_updateAttributes = [];
        return $this;
    }
}