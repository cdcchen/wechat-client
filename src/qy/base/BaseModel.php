<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 15:27
 */

namespace cdcchen\wechat\qy\base;


/**
 * Class BaseModel
 * @package cdcchen\wechat\qy\base
 */
abstract class BaseModel
{
    /**
     * @var array
     */
    private $_attributes;
    /**
     * @var array
     */
    private $_fields;

    /**
     * @return array
     */
    abstract protected function fields();

    /**
     * BaseModel constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $methodName = 'set' . ucfirst($name);
            if (method_exists($this, $methodName)) {
                call_user_func([$this, $methodName], $value);
            } else {
                $this->setAttribute($name, $value);
            }
        }

        $this->init();
    }

    /**
     * init
     */
    protected function init()
    {

    }

    /**
     * @param string $name
     * @param mixed $value
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

    /**
     * @param array $attributes
     * @return $this
     */
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

    /**
     * @param string $name
     * @return $this
     */
    protected function removeAttribute($name)
    {
        unset($this->_attributes[$name]);
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function toArray()
    {
        if ($this->beforeBuild()) {
            $attributes = $this->buildAttributes($this->_attributes);
            return $this->afterBuild($attributes);
        }

        return false;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
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

    /**
     * @return bool
     */
    protected function beforeBuild()
    {
        return true;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function afterBuild($attributes)
    {
        return $attributes;
    }

    /**
     * @return array
     */
    private function getFields()
    {
        if ($this->_fields === null) {
            $this->_fields = static::fields();
        }

        return $this->_fields;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->getFields())) {
            $this->setAttribute($name, $value);
        } else {
            throw new \InvalidArgumentException("$name is not a valid attribute.");
        }
    }

    /**
     * @param string $name
     * @return array|bool|string
     */
    public function __get($name)
    {
        if (in_array($name, $this->getFields())) {
            return $this->getAttribute($name);
        }

        throw new \InvalidArgumentException("$name is not a valid attribute.");
    }
}