<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:10
 */

namespace cdcchen\wechat\qy\base;


/**
 * Class UpdateAttributeTrait
 * @package cdcchen\wechat\qy\base
 */
trait UpdateAttributeTrait
{
    /**
     * @var array
     */
    protected $_updateAttributes = [];

    /**
     * @param string $attribute
     * @param string $value
     * @return $this
     */
    public function setUpdateAttribute($attribute, $value)
    {
        $this->_updateAttributes[$attribute] = $value;
        return $this;
    }

    /**
     * @return $this
     */
    public function resetUpdateAttributes()
    {
        $this->_updateAttributes = [];
        return $this;
    }
}