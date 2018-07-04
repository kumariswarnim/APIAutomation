<?php

namespace Tests\Api\User;

use ApiTester;
use Helper\Api;
use Helper\CourseLanguage;
use Helper\User;

class PostRegisterCest
{
    //All"non-required" fields: interface_language, learning_language, name and speaking_language are not covered

    /**
     * @group IntOnly
     */
    public function testRegisterSuccess(ApiTester $I)
    {
        $I->wantToTest('valid POST request to register');
        $I->register(User::USERNAME, Api::generateRandomEmail(), User::PASSWORD, CourseLanguage::ENGLISH, 200);
        $I->assertTrue($I->isResponseMatchingSchema('user/loginRegister'));
    }

    /**
     * @group ProdOnly
     */

    public function testRegisterEmailAlreadyExistsError(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to register - email already exists');
        $I->register(User::USERNAME, User::PREMIUM_EMAIL, User::PASSWORD,CourseLanguage::ENGLISH, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testRegisterEmptyBodyError(ApiTester $I)
    {
        $I->wantToTest('valid POST request to register - empty request body');
        $I->register(null, null, null, null, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testRegisterInvalidEmailFormatError(ApiTester $I)
    {
        //FIXME - Unable to test this scenario as integration is broken and I can still register without a proper email format
    }
}