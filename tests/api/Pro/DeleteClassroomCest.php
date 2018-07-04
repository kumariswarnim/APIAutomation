<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\CourseLanguage;
use Helper\Pro;

class DeleteClassroomCest
{
    const REQUEST_NAME_KEY = 'name';
    const REQUEST_LANGUAGE_KEY = 'language';
    const REQUEST_INSTRUCTORS_KEY = 'instructors';

    /**
     * @group IntOnly
     */
    public function testDeleteClassroomAdminUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to delete a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        //Create a classroom first
        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (delete classroom test)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::GERMAN,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 200);
        $classroomId = $I->grabDataFromResponseByJsonPath('$.data.id')['0'];

        //Then delete it
        $I->deleteProClassroom($classroomId, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/deleteClassroom'));
    }

    /**
     * @group IntOnly
     */
    public function testDeleteClassroomInstructorUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from instructor user to delete a classroom');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        //Create a classroom first
        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (delete classroom test)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::GERMAN,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 200);
        $classroomId = $I->grabDataFromResponseByJsonPath('$.data.id')['0'];

        //Then delete it
        $I->deleteProClassroom($classroomId, 200);
        $I->assertTrue($I->isResponseMatchingSchema('pro/deleteClassroom'));
    }
}