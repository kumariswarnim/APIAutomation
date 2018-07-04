<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetInstitutionAdminsCest
{
    public function testGetInstitutionAdminsSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid super user request to GET all admins of an institution');
        $I->login(Pro::SUPER_ADMIN_EMAIL, Pro::SUPER_ADMIN_PASSWORD, 200);
        $I->getProInstitutionAdmins(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getInstitutionAdmins'));
    }

    public function testGetInstitutionAdminsErrorAccessDenied(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET all admins of an institution - Access Denied');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionAdmins(Pro::OTHER_INSTITUTION_ID, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetInstitutionAdminsErrorInstitutionNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET all admins of an institution - Institution Not Found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionAdmins(Pro::INSTITUTION_THAT_WONT_BE_FOUND, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}