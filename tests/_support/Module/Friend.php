<?php

namespace Module;

class Friend extends AbstractModule
{
    /**
     * Sends a get request to retrieve a list of pending friend requests and validates response code
     *
     * @param $limit
     * @param $offset
     * @param $responseCode
     */
    public function getPendingFriends($limit, $offset, $responseCode)
    {
        $this->sendGetAndCheckResponse("/friends/pending?limit=$limit&offset=$offset", $responseCode);
    }

    /**
     * Sends a post request to send a friend request and validates response code
     *
     * @param $uid
     * @param $responseCode
     */
    public function sendFriendRequest($uid, $responseCode)
    {
        $this->sendPostAndCheckResponse("/friends/send/$uid", $params = null, $responseCode);
    }

    /**
     * Sends a post request to accept/reject a pending friend request and validates response code
     *
     * @param $url
     * @param $accept - 1 is accept, 0 is a reject
     * @param $requesterId
     * @param $responseCode
     */
    public function validateFriendRequest($url, $accept, $requesterId, $responseCode)
    {
        $this->sendPostAndCheckResponse($url, [
            'accept' => $accept,
            'requesterId' => $requesterId,
        ], $responseCode);
    }

    /**
     * Sends a delete request to delete a friend and validates response code
     *
     * @param $userId
     * @param $responseCode
     */

    public function deleteFriend($userId, $responseCode)
    {
        $this->sendDeleteAndCheckResponse("/friends/$userId", $responseCode);
    }

    /**
     * Sends a get request to search for a friend and validates response code
     *
     * @param $uid
     * @param $language
     * @param $limit
     * @param $offset
     * @param $searchQueryString
     * @param $sort
     * @param $responseCode
     */
    public function searchFriend($uid, $language, $limit, $offset, $searchQueryString, $sort, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid/friends?language=$language&limit=$limit&offset=$offset&q=$searchQueryString&sort[firstname]=$sort", $responseCode);
    }

    /**
     * Sends a get request to fetch your friend list and validates response code
     *
     * @param $uid
     * @param $limit
     * @param $offset
     * @param $sort
     * @param $responseCode
     */
    public function getFriendList($uid, $limit, $offset, $sort, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid/friends?limit=$limit&offset=$offset&sort[firstname]=$sort", $responseCode);
    }
}