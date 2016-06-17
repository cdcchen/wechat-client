<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 10:34
 */

namespace cdcchen\wechat\qy\contact;


/**
 * Class TagDeleteMemberRequest
 * @package cdcchen\wechat\qy\contact
 */
class TagDeleteMemberRequest extends TagAddMemberRequest
{
    /**
     * @var string
     */
    protected $action = '/cgi-bin/tag/deltagusers';
}