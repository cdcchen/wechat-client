<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 12:30
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\wechat\auth\CallbackCredential;
use cdcchen\wechat\base\BaseRequest;

/**
 * Class BatchReplaceDepartmentRequest
 * @package cdcchen\wechat\qy\contact
 */
class BatchReplaceDepartmentRequest extends BatchAsyncRequest
{
    /**
     * @var string
     */
    protected $action = '/cgi-bin/batch/replaceparty';
}