<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\Pro;

class GetClassroomStudentsCest
{
    /**
     * @group ProdOnly
     */
    public function testGetClassroomStudentsSuccessProduction(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to GET the list of students of a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProClassroomStudents(Pro::CLASSROOM_ID_PRODUCTION, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getClassroomStudents'));
    }

    /**
     * @group IntOnly
     */
    public function testGetClassroomStudentsSuccessIntegration(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to GET the list of students of a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProClassroomStudents(Pro::CLASSROOM_ID_INTEGRATION, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/getClassroomStudents'));
    }

    public function testGetClassroomInvitesForbidden(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid admin request to GET all the students of a classroom where access is not granted, forbidden');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProClassroomStudents(951, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetClassroomInvitesUrlNotFound(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid admin request to GET all the students of an invalid classroom, url not found');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);
        $I->getProClassroomStudents(1000000, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}