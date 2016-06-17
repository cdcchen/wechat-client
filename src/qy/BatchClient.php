<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/12
 * Time: 15:27
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\auth\CallbackCredential;
use cdcchen\wechat\qy\contact\BatchAsyncRequest;
use cdcchen\wechat\qy\contact\BatchReplaceDepartmentRequest;
use cdcchen\wechat\qy\contact\BatchReplaceUserRequest;
use cdcchen\wechat\qy\contact\BatchResultRequest;
use cdcchen\wechat\qy\contact\BatchSyncUserRequest;

/**
 * Class BatchClient
 * @package cdcchen\wechat\qy\contact
 */
class BatchClient extends DefaultClient
{
    /**
     * batch job status: started
     */
    const STATUS_STARTED = 1;
    /**
     * batch job status: doing
     */
    const STATUS_DOING = 2;
    /**
     * batch job status: completed
     */
    const STATUS_COMPLETED = 3;

    /**
     * batch job type: synn_user
     */
    const TYPE_SYNC_USER = 'sync_user';
    /**
     * batch job type: replace_user
     */
    const TYPE_REPLACE_USER = 'replace_user';
    /**
     * batch job type: replace_party
     */
    const TYPE_REPLACE_PARTY = 'replace_party';

    /**
     * batch job action: new_user
     */
    const ACTION_NEW_USER = 0x01;
    /**
     * batch job action: update_user
     */
    const ACTION_UPDATE_USER = 0x10;

    /**
     * batch job action: new_party
     */
    const ACTION_NEW_PARTY = 0x0001;
    /**
     * batch job action: update_party_name
     */
    const ACTION_UPDATE_PARTY_NAME = 0x0010;
    /**
     * batch job action: move_party
     */
    const ACTION_MOVE_PARTY = 0x0100;
    /**
     * batch job action: update_party_order
     */
    const ACTION_UPDATE_PARTY_ORDER = 0x1000;


    /**
     * @param string $mediaId
     * @param string $url
     * @param string $token
     * @param string $encodingAesKey
     * @return string
     */
    public function syncUsers($mediaId, $url = '', $token = '', $encodingAesKey = '')
    {
        $request = new BatchSyncUserRequest();
        return $this->request($request, $mediaId, $url, $token, $encodingAesKey);
    }

    /**
     * @param string $mediaId
     * @param string $url
     * @param string $token
     * @param string $encodingAesKey
     * @return string
     */
    public function replaceUsers($mediaId, $url = '', $token = '', $encodingAesKey = '')
    {
        $request = new BatchReplaceUserRequest();
        return $this->request($request, $mediaId, $url, $token, $encodingAesKey);
    }

    /**
     * @param string $mediaId
     * @param string $url
     * @param string $token
     * @param string $encodingAesKey
     * @return string
     */
    public function replaceParty($mediaId, $url = '', $token = '', $encodingAesKey = '')
    {
        $request = new BatchReplaceDepartmentRequest();
        return $this->request($request, $mediaId, $url, $token, $encodingAesKey);
    }

    /**
     * @param string $jobId
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getResult($jobId)
    {
        $request = (new BatchResultRequest())->setJobId($jobId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return $response->getData();
        });
    }


    /**
     * @param BatchAsyncRequest $request
     * @param string $mediaId
     * @param string $url
     * @param string $token
     * @param string $encodingAesKey
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    protected function request(BatchAsyncRequest $request, $mediaId, $url, $token, $encodingAesKey)
    {
        $callback = new CallbackCredential($url, $token, $encodingAesKey);
        $request->setMediaId($mediaId)->setCallback($callback);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['jobid'];
        });
    }
}