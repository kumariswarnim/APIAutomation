<?php

namespace Tests\Api\User;

use ApiTester;
use Helper\User;

class PostLoginCest
{
    public function testLoginSuccess(ApiTester $I)
    {
        $I->wantToTest('valid POST request to login');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->assertTrue($I->isResponseMatchingSchema('user/loginRegister'));
    }

    public function testLoginInvalidPasswordError(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to login - invalid password');
        $I->login(User::PREMIUM_EMAIL, User::INVALID_PASSWORD, 401);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testLoginEmailNotRegisteredError(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to login - unregistered email');
        $I->login(User::UNREGISTERED_EMAIL, User::INVALID_PASSWORD, 401);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testLoginEmptyBodyError(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to login - empty body');
        $I->login(null, null, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}