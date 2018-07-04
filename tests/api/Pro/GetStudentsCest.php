<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetStudentsCest
{
    /*
     * NOTE - we do not have the session_length information in integration environments. This is a result of Bruce only
     * running his session_length jobs in production. Hence, the session keys within getStudents.json are not marked as
     * 'required'
     */

    public function testAdminUserGetStudentsSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to GET all students of an institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProStudents(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getStudents'));
    }

    public function testInstructorUserGetStudentsSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from instructor user to GET all students of an institution');
        $I->login(Pro::INSTRUCTOR_EMAIL, Pro::INSTRUCTOR_PASSWORD, 200);
        $I->getProStudents(Pro::INSTITUTION_ID, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getStudents'));
    }

    /**
     * @group IntOnly
     */
    public function testGetStudentsErrorAccessDenied(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to GET all students of an institution - Access Denied');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProStudents(Pro::OTHER_INSTITUTION_ID, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}