<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午1:48
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\contact\OpenIdToUserIdRequest;
use cdcchen\wechat\qy\contact\UserBatchDeleteRequest;
use cdcchen\wechat\qy\contact\UserCreateRequest;
use cdcchen\wechat\qy\contact\UserDeleteRequest;
use cdcchen\wechat\qy\contact\UserDetailListRequest;
use cdcchen\wechat\qy\contact\UserIdToOpenIdRequest;
use cdcchen\wechat\qy\contact\UserInfoRequest;
use cdcchen\wechat\qy\contact\UserSimpleListRequest;
use cdcchen\wechat\qy\contact\UserUpdateRequest;

/**
 * Class UserClient
 * @package cdcchen\wechat\qy\contact
 */
class UserClient extends DefaultClient
{
    /**
     * Api convert_to_openid path
     */
    const API_CONVERT_TO_OPENID = '/cgi-bin/user/convert_to_openid';
    /**
     * Api convert_to_userid path
     */
    const API_CONVERT_TO_USERID = '/cgi-bin/user/convert_to_userid';


    /**
     * @param UserCreateRequest $request
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function create(UserCreateRequest $request)
    {
        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $id
     * @param UserUpdateRequest $request
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function update($id, UserUpdateRequest $request)
    {
        $request->setUserId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($id)
    {
        $request = (new UserDeleteRequest())->setUserId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param array $users
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function batchDelete($users)
    {
        $request = (new UserBatchDeleteRequest())->setUsers($users);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param string $id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getInfo($id)
    {
        $request = (new UserInfoRequest())->setUserId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });

    }

    /**
     * @param int $departmentId
     * @param int $status
     * @param bool $fetchChild
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getSimpleList($departmentId, $status = null, $fetchChild = false)
    {
        $request = (new UserSimpleListRequest())->setDepartmentId($departmentId)
                                                ->setFetchChild($fetchChild);

        if (is_int($status)) {
            $request->setStatus($status);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userlist'];
        });
    }

    /**
     * @param int $departmentId
     * @param int $status
     * @param bool $fetchChild
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getDetailList($departmentId, $status = null, $fetchChild = false)
    {
        $request = (new UserDetailListRequest())->setDepartmentId($departmentId)
                                                ->setFetchChild($fetchChild);

        if (is_int($status)) {
            $request->setStatus($status);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userlist'];
        });
    }

    /**
     * @param string $id
     * @param int|null $agentId
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getOpenIdByUserId($id, $agentId = null)
    {
        $request = (new UserIdToOpenIdRequest())->setUserId($id);
        if (is_int($agentId)) {
            $request->setAgentId($agentId);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @param string $openId
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getUserIdByOpenId($openId)
    {
        $request = (new OpenIdToUserIdRequest())->setOpenId($openId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userid'];
        });
    }

}