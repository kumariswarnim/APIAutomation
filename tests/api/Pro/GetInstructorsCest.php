<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetInstructorsCest
{
    public function testGetInstructorsAdminUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to GET all instructors of an institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionInstructors(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getInstitutionInstructors'));
    }

    public function testGetInstructorsInstructorUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from instructor user to GET all instructors of an institution');
        $I->login(Pro::INSTRUCTOR_EMAIL, Pro::INSTRUCTOR_PASSWORD, 200);
        $I->getProInstitutionInstructors(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getInstitutionInstructors'));
    }

    public function testGetClassroomInstructorsSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request to GET all instructors of a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProClassroomInstructors(PRO::CLASSROOM_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getClassroomInstructors'));
    }

    /**
     * @group IntOnly
     */
    public function testGetInstructorsErrorAccessDeniedWrongInstitution(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET all instructors of an institution - Access Denied - Other institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionInstructors(Pro::OTHER_INSTITUTION_ID, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}