<?php

namespace Tests\Api\UserAvatar;

use ApiTester;
use Helper\User;

class GetUserAvatarListCest
{
    public function testGetUserAvatarListSuccess(ApiTester $I){
        $I->wantToTest('valid request to GET list of avatar for a user');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->getUserAvatarList($uid,200);
        $I->assertTrue($I->isResponseMatchingSchema('userAvatar/getUserAvatarList'));
    }

    public function testGetUserAvatarListForbiddenOnIntegration(ApiTester $I){
        $I->wantToTest('invalid request to GET list of avatar for a user, forbidden');
        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->getUserAvatarList(90,403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetUserAvatarListUrlNotFound(ApiTester $I){
        $I->wantToTest('invalid request to GET list of avatar for a user, forbidden');
        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $I->getUserAvatarList(185461672345129346751234,404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}