<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GenerateStudentsCsvForInstitutionCest
{
    public function testGenerateStudentsCsvSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to generate the students CSV file');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->generateStudentsCsvFileForInstitution(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/generateStudentsCsvForInstitution'));
    }

    public function testGenerateStudentsCsvErrorUnauthorized(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request from admin user to generate the students CSV file, unauthorized');
        $I->generateStudentsCsvFileForInstitution(Pro::INSTITUTION_ID, 401);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    public function testGenerateStudentsCsvErrorUrlNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request from admin user to generate the students CSV file, url not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->generateStudentsCsvFileForInstitution(100000, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}