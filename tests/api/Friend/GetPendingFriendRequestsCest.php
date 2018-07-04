<?php

namespace Tests\Api\Friend;

use ApiTester;
use Helper\Friend;
use Helper\User;

class GetPendingFriendRequestsCest
{
    public function testGetPendingFriendRequestsSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET all pending friend requests for a user');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);

        $I->getPendingFriends(Friend::LIMIT, Friend::OFFSET, 200);
        $I->assertTrue($I->isResponseMatchingSchema('friend/getPendingFriendRequest'));
    }

    public function testGetPendingFriendRequestsWithNoPendingFriendsSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET all pending friend requests for a user - when there are no pending requests');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);

        $I->getPendingFriends(Friend::LIMIT, Friend::OFFSET, 200);
        $I->assertTrue($I->isResponseMatchingSchema('friend/getPendingFriendRequest'));
    }
}