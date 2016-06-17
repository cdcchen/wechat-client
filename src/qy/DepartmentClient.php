<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午10:23
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\contact\DepartmentCreateRequest;
use cdcchen\wechat\qy\contact\DepartmentDeleteRequest;
use cdcchen\wechat\qy\contact\DepartmentListRequest;
use cdcchen\wechat\qy\contact\DepartmentUpdateRequest;

/**
 * Class DepartmentClient
 * @package cdcchen\wechat\qy\contact
 */
class DepartmentClient extends DefaultClient
{
    /**
     * @param null|int $id
     * @return array
     * @deprecated
     */
    public function select($id = null)
    {
        return $this->getList($id);
    }

    /**
     * @param null|int $id
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getList($id = null)
    {
        $request = (new DepartmentListRequest())->setId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['department'];
        });
    }

    /**
     * @param string $name
     * @param int $parentId
     * @param int $order
     * @param int $id
     * @return int
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function create($name, $parentId = 1, $id = 0, $order = 0)
    {
        $request = (new DepartmentCreateRequest())->setName($name)->setParentId($parentId);

        if ($order > 0) {
            $request->setOrder($order);
        }
        if ($id > 0) {
            $request->setId($id);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['id'];
        });
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $parentId
     * @param null|int $order
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function update($id, $name = null, $parentId = null, $order = null)
    {
        $request = (new DepartmentUpdateRequest())->setId($id);

        if ($name) {
            $request->setName($name);
        }

        if (is_int($parentId)) {
            $request->setParentId($parentId);
        }

        if (is_int($order)) {
            $request->setOrder($order);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($id)
    {
        $request = (new DepartmentDeleteRequest())->setId($id);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return true;
        });
    }
}