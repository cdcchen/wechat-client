<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 12:30
 */

namespace cdcchen\wechat\qy\contact;


/**
 * Class BatchSyncUserRequest
 * @package cdcchen\wechat\qy\contact
 */
class BatchSyncUserRequest extends BatchAsyncRequest
{
    /**
     * @var string
     */
    protected $action = '/cgi-bin/batch/syncuser';
}