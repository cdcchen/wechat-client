<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class BatchJobEvent
 * @package cdcchen\wechat\qy\push\models
 */
class BatchJobEvent extends EventMessage
{
    const TYPE_SYNC_USER     = 'sync_user';
    const TYPE_REPLACE_USER  = 'replace_user';
    const TYPE_INVITE_USER   = 'invite_user';
    const TYPE_REPLACE_PARTY = 'replace_party';

    /**
     * @return null|string
     */
    public function getJobId()
    {
        return $this->getBatchJob('JobID');
    }

    /**
     * @return int
     */
    public function getJobType()
    {
        return (int)$this->getBatchJob('JobType');
    }

    /**
     * @return int
     */
    public function getErrCode()
    {
        return (int)$this->getBatchJob('ErrCode');
    }

    /**
     * @return null|string
     */
    public function getErrMsg()
    {
        return $this->getBatchJob('ErrMsg');
    }

    /**
     * @param string $name
     * @return null|mixed
     */
    private function getBatchJob($name)
    {
        $job = $this->get('BatchJob');
        if ($job === null) {
            return null;
        }

        return isset($job[$name]) ? $job[$name] : null;
    }
}