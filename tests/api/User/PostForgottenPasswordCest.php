<?php

namespace Tests\Api\User;

use ApiTester;
use Helper\User;

class PostForgottenPasswordCest
{
    public function testPostForgottenPasswordSuccess(ApiTester $I)
    {
        $I->wantToTest('valid POST request to forgotten password');
        $I->postForgetPassword(User::PREMIUM_EMAIL, 200);
        $I->seeResponseMatchesJsonType([
            'status' => 'string'
        ]);
    }

    public function testPostForgottenPasswordEmptyBodyError(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to forgotten password - empty body');
        $I->postForgetPassword(null, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    public function testPostForgottenPasswordEmailNotRegisteredError(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to forgotten password - email not registered');
        $I->postForgetPassword(User::UNREGISTERED_EMAIL, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}