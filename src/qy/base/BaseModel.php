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
    private $_attributes;
    private $_fields;

    abstract protected function fields();

    public function __construct($attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $methodName = 'set' . ucfirst($name);var_dump($methodName);
            if (method_exists($this, $methodName)) {
                call_user_func([$this, $methodName], $value);
            }
            else {
                $this->setAttribute($name, $value);
            }
        }

        $this->init();
    }

    protected function init()
    {

    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    protected function setAttribute($name, $value)
    {
        $names = explode('.', $name);

        if (isset($names[1])) {
            $this->_attributes[$names[0]][$names[1]] = $value;
        } else {
            $this->_attributes[$name] = $value;
        }

        return $this;
    }

    protected function setAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * @param $name
     * @return bool|string|array
     */
    protected function getAttribute($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : false;
    }

    protected function removeAttribute($name)
    {
        unset($this->_attributes[$name]);
        return $this;
    }

    public function toArray()
    {
        if ($this->beforeBuild()) {
            $attributes = $this->buildAttributes($this->_attributes);
            return $this->afterBuild($attributes);
        }

        return false;
    }

    private function buildAttributes($attributes)
    {
        foreach ($attributes as $key => $attribute) {
            if ($attribute instanceof BaseModel) {
                $attributes[$key] = $attribute->toArray();
            } elseif (is_array($attribute)) {
                $attributes[$key] = $this->buildAttributes($attribute);
            }
        }

        return $attributes;
    }

    protected function beforeBuild()
    {
        return true;
    }

    protected function afterBuild($attributes)
    {
        return $attributes;
    }

    private function getFields()
    {
        if ($this->_fields === null) {
            $this->_fields = static::fields();
        }

        return $this->_fields;
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->getFields())) {
            $this->setAttribute($name, $value);
        } else {
            throw new \InvalidArgumentException("$name is not a valid attribute.");
        }
    }

    public function __get($name)
    {
        if (in_array($name, $this->getFields())) {
            return $this->getAttribute($name);
        }

        throw new \InvalidArgumentException("$name is not a valid attribute.");
    }
}