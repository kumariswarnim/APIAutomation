<?php

namespace Tests\Api\Friend;

use ApiTester;
use Helper\Api;
use Helper\CourseLanguage;
use Helper\User;

class ValidateFriendRequestCest
{
    public function testAcceptFriendRequestSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to accept a friend request');
        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1

        $user2Email = Api::generateRandomEmail();
        $user2Username = Api::generateRandomUsername();

        $I->registerAndReturnUid($user2Username, $user2Email, User::PASSWORD, CourseLanguage::ENGLISH, 200); //register user 2
        $user2Uid = $I->loginAndReturnUid($user2Email, User::PASSWORD); //login as user 2

        $I->sendFriendRequest($user1Uid, 200); //user 2 sends a friend request to user 1

        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200); //login as user 1 again

        $I->validateFriendRequest("/friends/validate", 1, $user2Uid, 200); //user 1 accepts user 2's friend request

        $I->assertTrue($I->isResponseMatchingSchema('friend/validateDeleteFriend'));
    }

    public function testRejectFriendRequestSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to reject a friend request');
        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1

        $user2Email = Api::generateRandomEmail();
        $user2Username = Api::generateRandomUsername();

        $I->registerAndReturnUid($user2Username, $user2Email, User::PASSWORD, CourseLanguage::ENGLISH, 200); //register user 2
        $user2Uid = $I->loginAndReturnUid($user2Email, User::PASSWORD); //login as user 2

        $I->sendFriendRequest($user1Uid, 200); //user 2 sends a friend request to user 1

        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200); //login as user 1 again

        $I->validateFriendRequest("/friends/validate", 0, $user2Uid, 200); //user 1 rejects user 2's friend request

        $I->assertTrue($I->isResponseMatchingSchema('friend/validateDeleteFriend'));
    }

    public function testValidateFriendRequestErrorNoPendingRequest(ApiTester $I)
    {
        $I->wantToTest('invalid request to validate a friend request - no pending request');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);

        $I->validateFriendRequest("/friends/validate", 0, 30416163, 400);

        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testValidateFriendRequestErrorUnknownUser(ApiTester $I)
    {
        $I->wantToTest('invalid request to validate a friend request - unknown user');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);

        $I->validateFriendRequest("/friends/validate", 0, 0, 400);

        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

}