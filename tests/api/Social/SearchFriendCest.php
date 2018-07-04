<?php

namespace Tests\Api\Social;

use ApiTester;
use Helper\Friend;
use Helper\User;
use Helper\CourseLanguage;

class SearchFriendCest
{
    public function testSearchFriendSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to search for a friend');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->searchFriend($uid, CourseLanguage::ENGLISH, Friend::LIMIT, Friend::OFFSET, "api", "asc", 200); //ascending
        $I->assertTrue($I->isResponseMatchingSchema('social/getFriendList'));
    }

    public function testSearchFriendErrorInvalidUser(ApiTester $I)
    {
        $I->wantToTest('invalid request to search for a friend - invalid user');
        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->searchFriend("067", CourseLanguage::ENGLISH, Friend::LIMIT, Friend::OFFSET, "api", "asc", 404); //ascending
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

//    public function testSearchFriendErrorInvalidLimit(ApiTester $I)
//    {
//        $I->wantToTest('invalid request to search for a friend - invalid limit');
//        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
//        $I->searchFriend($uid, CourseLanguage::ENGLISH, -1, Friend::OFFSET, "api", "asc", 400); //TODO backend to fix - currently gives a 200 response
//        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
//    }
//
//    public function testSearchFriendErrorInvalidOffset(ApiTester $I)
//    {
//        $I->wantToTest('invalid request to search for a friend - invalid offset');
//        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
//        $I->searchFriend($uid, CourseLanguage::ENGLISH, Friend::LIMIT, -1, "api", "asc", 400); //TODO backend to fix - currently gives a 200 response
//        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
//    }
}