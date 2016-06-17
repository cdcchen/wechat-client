<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 12:46
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class BatchResultRequest
 * @package cdcchen\wechat\qy\contact
 */
class BatchResultRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/batch/getresult';

    /**
     * @param string $value
     * @return $this
     */
    public function setJobId($value)
    {
        return $this->setQueryParam('jobid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['jobid'];
    }
}