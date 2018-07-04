<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetClassroomsCest
{
    public function testGetInstitutionClassroomsAdminUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to GET the classrooms in an institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionClassrooms(Pro::INSTITUTION_ID, Pro::ROLE_ADMIN, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getInstitutionClassrooms'));
    }

    public function testGetInstitutionClassroomsInstructorUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from instructor user to GET the classrooms in an institution');
        $I->login(Pro::INSTRUCTOR_EMAIL, Pro::INSTRUCTOR_PASSWORD, 200);
        $I->getProInstitutionClassrooms(Pro::INSTITUTION_ID, Pro::ROLE_INSTRUCTOR, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getInstitutionClassrooms'));
    }

    public function testGetInstitutionClassroomsErrorAccessDenied(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET the classrooms in an institution - user does not have access to institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionClassrooms(Pro::OTHER_INSTITUTION_ID, Pro::ROLE_ADMIN, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetInstitutionClassroomsErrorInstitutionNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET the classrooms in an institution - Institution not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProInstitutionClassrooms(Pro::INSTITUTION_THAT_WONT_BE_FOUND, Pro::ROLE_ADMIN, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}