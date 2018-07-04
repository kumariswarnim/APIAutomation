<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;
use Helper\User;

class GetASpecificInstitutionCest
{
    public function testGetASpecificInstitutionSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid admin user request to GET a specific institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getASpecificProInstitution(Pro::OTHER_INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getASpecificInstitution'));
    }

    public function testGetASpecificInstitutionForbidden(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid premium user request to GET a specific institution, forbidden');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->getASpecificProInstitution(Pro::OTHER_INSTITUTION_ID, 403);
        $I->isResponseMatchingSchema('common/errorWithAppCode');
    }

    public function testGetASpecificInstitutionUrlNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid premium user request to GET a specific institution, url not found');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->getASpecificProInstitution(0, 404);
        $I->isResponseMatchingSchema('common/error');
    }
}