<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/16
 * Time: 16:58
 */

namespace cdcchen\wechat\base;


/**
 * Class BaseRequest
 * @package cdcchen\wechat\base
 */
abstract class BaseRequest extends Object
{
    /**
     * @var string
     */
    protected $method;
    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    private $_host;
    /**
     * @var array
     */
    private $_queryParams = [];
    /**
     * @var mixed
     */
    private $_data;

    /**
     * BaseRequest constructor.
     */
    public function __construct()
    {
        $this->init();
        $this->setDefaultParams();
    }

    /**
     * init
     */
    protected function init()
    {
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setHost($value)
    {
        $this->_host = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        $url = $this->_host . '/' . ltrim($this->action, '/');

        return $url . '?' . http_build_query($this->getQueryParams());
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    protected function setQueryParam($name, $value)
    {
        $this->_queryParams[$name] = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function mergeQueryParams(array $params)
    {
        foreach ($params as $name => $value) {
            $this->setQueryParam($name, $value);
        }
        return $this;
    }

    /**
     * @return array
     */
    private function getQueryParams()
    {
        return $this->_queryParams;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    protected function setData($name, $value)
    {
        $this->_data[$name] = $value;
        return $this;
    }

    /**
     * @param null $name
     * @return mixed|null
     */
    public function getData($name = null)
    {
        if (empty($name)) {
            return $this->_data;
        } elseif (is_array($this->_data)) {
            return isset($this->_data[$name]) ? $this->_data[$name] : null;
        } else {
            throw new \InvalidArgumentException('Data is not a array.');
        }
    }

    /**
     * @param string $value
     * @return $this
     */
    protected function setBody($value)
    {
        $this->_data = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return strtolower($this->method) === 'post';
    }

    /**
     * Set default params
     */
    protected function setDefaultParams()
    {
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return [];
    }

    /**
     * prepare for send
     */
    protected function prepare()
    {
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $this->prepare();
        return $this->checkRequireParams();
    }

    /**
     * @return bool
     */
    private function checkRequireParams()
    {
        $requireParams = (array)$this->getRequireParams();
        if (empty($requireParams)) {
            return true;
        }

        $params = is_array($this->_data) ? array_merge($this->_queryParams, $this->_data) : $this->_queryParams;

        foreach ($requireParams as $param) {
            if (!isset($params[$param])) {
                throw new \InvalidArgumentException("$param is required.");
            }
        }

        return true;
    }

}