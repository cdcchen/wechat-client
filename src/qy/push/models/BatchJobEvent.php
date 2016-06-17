<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


class BatchJobEvent extends Event
{
    const TYPE_SYNC_USER     = 'sync_user';
    const TYPE_REPLACE_USER  = 'replace_user';
    const TYPE_INVITE_USER   = 'invite_user';
    const TYPE_REPLACE_PARTY = 'replace_party';

    public $jobID;
    public $jobType;
    public $errCode;
    public $errMsg;

    protected function parseEventXml()
    {
        $batchJOb = $this->_xml->BatchJob;

        $this->jobID = (string)$batchJOb->JobID;
        $this->jobType = (int)$batchJOb->JobType;
        $this->errCode = (int)$batchJOb->ErrCode;
        $this->errMsg = (string)$batchJOb->ErrMsg;
    }
}