<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetReportCest
{
    public function testGetReportSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request to GET all data needed for the busuu Pro Report tab');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProReport(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getReport'));
    }

    public function testGetReportErrorAccessDeniedBasedOnUserLevel(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET all data needed for the busuu Pro Report tab - Instructor user');
        $I->login(Pro::INSTRUCTOR_EMAIL, Pro::INSTRUCTOR_PASSWORD, 200);
        $I->getProReport(Pro::INSTITUTION_ID, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
    public function testGetReportErrorInstitutionNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET all data needed for the busuu Pro Report tab - Institution not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProReport(Pro::INSTITUTION_THAT_WONT_BE_FOUND, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}