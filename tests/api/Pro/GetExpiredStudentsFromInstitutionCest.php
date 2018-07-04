<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetExpiredStudentsFromInstitutionCest
{
    public function testGetExpiredStudentsFromInstitutionSuccess(ApiTester $I){
        $I->wantToTest("BusuuPRO - valid request from a super admin user to GET the list of expired students in an institution");
        $I->login(Pro::SUPER_ADMIN_EMAIL, Pro::SUPER_ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromInstitution(Pro::OTHER_INSTITUTION_ID, 200);
        $I->isResponseMatchingSchema('pro/getExpiredStudentsFromInstitution');
    }

    public function testGetExpiredStudentsFromInstitutionForbidden(ApiTester $I){
        $I->wantToTest("BusuuPRO - invalid request from a admin user to GET the list of expired students in an institution, forbidden");
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromInstitution(Pro::OTHER_INSTITUTION_ID, 403);
        $I->isResponseMatchingSchema('common/errorWithAppCode');
    }

    public function testGetExpiredStudentsFromInstitutionUrlNotFound(ApiTester $I){
        $I->wantToTest("BusuuPRO - invalid request from a admin user to GET the list of expired students in an institution, url not found");
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getExpiredStudentsFromInstitution(0, 404);
        $I->isResponseMatchingSchema('common/error');
    }
}