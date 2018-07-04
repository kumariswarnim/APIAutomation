<?php

namespace Tests\Api\Social;

use ApiTester;
use Helper\Friend;
use Helper\User;

class GetUserFriendListCest
{
    public function testGetUserFriendListSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET the list of friends for a user');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->getFriendList($uid, Friend::LIMIT, Friend::OFFSET, "asc", 200); //ascending
        $I->assertTrue($I->isResponseMatchingSchema('social/getFriendList'));
    }

    public function testGetUserFriendListErrorInvalidUser(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET the list of friends for a user - invalid user');
        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->getFriendList("067", Friend::LIMIT, Friend::OFFSET, "asc", 404); //ascending
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

//    public function testGetUserFriendListErrorInvalidLimit(ApiTester $I)
//    {
//        $I->wantToTest('invalid request to GET the list of friends for a user - invalid limit');
//        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
//        $I->getFriendList($uid, -1, Friend::OFFSET, "asc", 400); //TODO backend to fix - currently gives a 200 response
//        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
//    }
//
//    public function testGetUserFriendListErrorInvalidOffset(ApiTester $I)
//    {
//        $I->wantToTest('invalid request to GET the list of friends for a user - invalid offset');
//        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
//        $I->getFriendList($uid, Friend::LIMIT, -1, "asc", 400); //TODO backend to fix - currently gives a 200 response
//        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
//    }
}