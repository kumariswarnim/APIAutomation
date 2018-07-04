<?php

namespace Tests\Api\User;

use ApiTester;
use Helper\User;

class GetUserInfoCest
{
    public function testGetPremiumUserInfoSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET user info - premium user');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->getUserInfo($uid, 200);
        $I->assertTrue($I->isResponseMatchingSchema('user/userInfo'));
    }

    public function testGetFreeUserInfoSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET user info - free user');
        $uid = $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);
        $I->getUserInfo($uid, 200);
        $I->assertTrue($I->isResponseMatchingSchema('user/userInfo'));
    }
}