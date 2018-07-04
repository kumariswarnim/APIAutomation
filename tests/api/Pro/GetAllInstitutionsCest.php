<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetAllInstitutionsCest
{
    public function testGetAllInstitutionsSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid super user request to GET all institutions');
        $I->login(Pro::SUPER_ADMIN_EMAIL, Pro::SUPER_ADMIN_PASSWORD, 200);
        $I->getAllProInstitutions(200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getAllInstitutions'));
    }

    public function testGetAllInstitutionsErrorAccessDenied(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid user request to GET all institutions');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getAllProInstitutions(403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}