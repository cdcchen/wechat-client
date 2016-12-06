<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午2:57
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\contact\TagAddMemberRequest;
use cdcchen\wechat\qy\contact\TagCreateRequest;
use cdcchen\wechat\qy\contact\TagDeleteMemberRequest;
use cdcchen\wechat\qy\contact\TagDeleteRequest;
use cdcchen\wechat\qy\contact\TagListRequest;
use cdcchen\wechat\qy\contact\TagMembersRequest;
use cdcchen\wechat\qy\contact\TagUpdateRequest;

/**
 * Class TagClient
 * @package cdcchen\wechat\qy\contact
 */
class TagClient extends DefaultClient
{
    /**
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getList()
    {
        $request = new TagListRequest();

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['taglist'];
        });
    }

    /**
     * @param string $name
     * @param int $id
     * @return int
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function create($name, $id = 0)
    {
        $request = (new TagCreateRequest())->setName($name);
        if ($id > 0) {
            $request->setId($id);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['tagid'];
        });
    }

    /**
     * @param int $id
     * @param string $name
     * @return bool
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function update($id, $name)
    {
        $request = (new TagUpdateRequest())->setId($id)->setName($name);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $id
     * @return bool
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function delete($id)
    {
        $request = (new TagDeleteRequest())->setId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $id
     * @return array
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function getMembers($id)
    {
        $request = (new TagMembersRequest())->setId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @param int $id
     * @param array $users
     * @param array $departments
     * @return bool
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function addMembers($id, array $users = [], array $departments = [])
    {
        $request = (new TagAddMemberRequest())->setId($id);
        if ($users) {
            $request->setUsers($users);
        }
        if ($departments) {
            $request->setDepartments($departments);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            if (isset($data['invalidlist']) || isset($data['invalidparty'])) {
                unset($data['errcode'], $data['errmsg']);
                return $data;
            } else {
                return true;
            }
        });
    }

    /**
     * @param int $id
     * @param array $users
     * @param array $departments
     * @return bool
     * @throws \cdcchen\wechat\base\ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function deleteMembers($id, array $users = [], array $departments = [])
    {
        $request = (new TagDeleteMemberRequest())->setId($id);
        if ($users) {
            $request->setUsers($users);
        }
        if ($departments) {
            $request->setDepartments($departments);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            if (isset($data['invalidlist']) || isset($data['invalidparty'])) {
                unset($data['errcode'], $data['errmsg']);
                return $data;
            } else {
                return true;
            }
        });
    }
}