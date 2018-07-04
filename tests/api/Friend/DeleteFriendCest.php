<?php

namespace Tests\Api\Friend;

use ApiTester;
use Helper\Api;
use Helper\CourseLanguage;
use Helper\User;

/**
 * Class DeleteFriendCest
 *
 * DELETE an active friendship test
 *
 * TODO add these descriptions in other CEST files
 */

class DeleteFriendCest
{
    public function testDeleteFriendSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to delete a friend');
        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1

        $user2Email = Api::generateRandomEmail();
        $user2Username = Api::generateRandomUsername();

        $I->registerAndReturnUid($user2Username, $user2Email, User::PASSWORD, CourseLanguage::ENGLISH, 200); //register user 2
        $user2Uid = $I->loginAndReturnUid($user2Email, User::PASSWORD); //login as user 2

        $I->sendFriendRequest($user1Uid, 200); //user 2 sends a friend request to user 1

        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200); //login as user 1 again

        $I->validateFriendRequest("/friends/validate", 1, $user2Uid, 200); //user 1 accepts user 2's friend request

        $I->deleteFriend($user2Uid, 200); //user 1 then deletes the friendship with user 2

        $I->assertTrue($I->isResponseMatchingSchema('friend/validateDeleteFriend'));
    }

    public function testDeleteFriendErrorRemovePendingFriend(ApiTester $I)
    {
        $I->wantToTest('invalid request to delete a friend - remove pending request');
        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1

        $user2Email = Api::generateRandomEmail();
        $user2Username = Api::generateRandomUsername();

        $I->registerAndReturnUid($user2Username, $user2Email, User::PASSWORD, CourseLanguage::ENGLISH, 200); //register user 2
        $user2Uid = $I->loginAndReturnUid($user2Email, User::PASSWORD); //login as user 2

        $I->sendFriendRequest($user1Uid, 200); //user 2 sends a friend request to user 1

        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200); //login as user 1 again

        $I->deleteFriend($user2Uid, 400); //user 1 attempts to deletes a non-existing friendship with user 2

        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testDeleteFriendErrorRemoveRejectedFriend(ApiTester $I)
    {
        $I->wantToTest('invalid request to delete a friend - remove a rejected request');
        $user1Uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD); //login as user 1

        $user2Email = Api::generateRandomEmail();
        $user2Username = Api::generateRandomUsername();

        $I->registerAndReturnUid($user2Username, $user2Email, User::PASSWORD, CourseLanguage::ENGLISH, 200); //register user 2
        $user2Uid = $I->loginAndReturnUid($user2Email, User::PASSWORD); //login as user 2

        $I->sendFriendRequest($user1Uid, 200); //user 2 sends a friend request to user 1

        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200); //login as user 1 again

        $I->validateFriendRequest("/friends/validate", 0, $user2Uid, 200); //user 1 rejects user 2's friend request

        $I->deleteFriend($user2Uid, 400); //user 1 attempts to deletes a non-existing friendship with user 2

        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testDeleteFriendErrorRemoveInvalidUser(ApiTester $I)
    {
        $I->wantToTest('invalid request to delete a friend - remove a invalid user');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->deleteFriend(0, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}