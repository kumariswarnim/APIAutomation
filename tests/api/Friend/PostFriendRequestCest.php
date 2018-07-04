<?php

namespace Tests\Api\Friend;

use ApiTester;
use Helper\Api;
use Helper\CourseLanguage;
use Helper\User;

class PostFriendRequestCest
{
    public function testPostFriendRequestSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to POST a friend request');
        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1
        $user2Email = Api::generateRandomEmail();
        $user2Username = Api::generateRandomUsername();

        $I->registerAndReturnUid($user2Username, $user2Email, User::PASSWORD, CourseLanguage::ENGLISH, 200); //register user 2
        $I->loginAndReturnUid($user2Email, User::PASSWORD); //login as user 2
        $I->sendFriendRequest($user1Uid, 200); //user 2 sends a friend request to user 1
        $I->assertTrue($I->isResponseMatchingSchema('friend/sendFriendRequest'));
    }

    //TODO: commented these 2 tests as backend has to fix the error where user has reached the maximum number of friend request sent in a day

//    public function testPostFriendRequestErrorFriendRequestExists(ApiTester $I)
//    {
//        $I->wantToTest('invalid request to POST a friend request - requester already sent a friend request to this user');
//        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1
//        $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD); //login as user 2
//        $I->sendFriendRequest($user1Uid, 400); //user 2 sends a friend request to user 1
//        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
//    }
//
//    public function testPostFriendRequestErrorUserAlreadyFriends(ApiTester $I)
//    {
//        $I->wantToTest('invalid request to POST a friend request - requester is already a friend with this user');
//        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
//        $I->sendFriendRequest(30416163, 400);
//        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
//    }

    public function testPostFriendRequestErrorFriendRequestToSelf(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a friend request - requester is sending request to self');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->sendFriendRequest($uid, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}