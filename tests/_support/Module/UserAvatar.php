<?php

namespace Module;

class UserAvatar extends AbstractModule
{
    /**
     * Sends a get request to retrieve the list of avatars for a specific user and validates response code
     *
     * @param $uid
     * @param $responseCode
     */
    public function getUserAvatarList($uid, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid/avatar/list", $responseCode);
    }
}