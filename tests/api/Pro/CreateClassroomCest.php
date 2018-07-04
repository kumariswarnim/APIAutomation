<?php

namespace Tests\Api\Pro;

use ApiTester;
use Helper\CourseLanguage;
use Helper\Pro;

class CreateClassroomCest
{
    const REQUEST_NAME_KEY = 'name';
    const REQUEST_LANGUAGE_KEY = 'language';
    const REQUEST_INSTRUCTORS_KEY = 'instructors';
    const CREATE_PRO_CLASSROOM_SCHEMA_FILE = 'pro/createProClassroom';

    /**
     * @group IntOnly
     */
    public function testCreateClassroomAdminUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to create a classroom (without instructors)');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (admin user, without instructors)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::ARABIC,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 200);

        $I->seeResponseContainsJson($requestParams);
        $I->assertTrue($I->isResponseMatchingSchema(static::CREATE_PRO_CLASSROOM_SCHEMA_FILE));
    }

    /**
     * @group IntOnly
     */
    public function testCreateClassroomInstructorUserSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from instructor user to create a classroom (without instructors)');
        $I->login(Pro::INSTRUCTOR_EMAIL, Pro::INSTRUCTOR_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (instructor user, without instructors)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::GERMAN,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 200);

        $I->seeResponseContainsJson($requestParams);
        $I->assertTrue($I->isResponseMatchingSchema(static::CREATE_PRO_CLASSROOM_SCHEMA_FILE));
    }

    /**
     * @group IntOnly
     */
    public function testCreateClassroomErrorUserNotInInstitution(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to create a classroom - user does not have access to that institution');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (institution I don\'t have access to)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::GERMAN,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::OTHER_INSTITUTION_ID, $requestParams, 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    /**
     * @group IntOnly
     */
    public function testCreateClassroomWithInstructorsSuccess(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - valid request from admin user to create a classroom (with instructors)');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (admin user, with instructors)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::ARABIC,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 200);

        $I->seeResponseContainsJson($requestParams);
        $I->assertTrue($I->isResponseMatchingSchema(static::CREATE_PRO_CLASSROOM_SCHEMA_FILE));
    }

    /**
     * @group IntOnly
     */
    public function testCreateClassroomWithInstructorsSuccessInvalidInstructorId(ApiTester $I)
    {
        $invalidInstructorId = 'I am not a valid user';

        $I->wantToTest('BusuuPRO - valid request to create a classroom (with an invalid instructor id) - classroom should still be created');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (with invalid instructor id)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::SPANISH,
                static::REQUEST_INSTRUCTORS_KEY => [$invalidInstructorId]
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 200);
        //TODO above could possibly throw a 400 if the instructor is not actually valid - talk with backend team

        $I->cantSeeResponseContainsJson(
            [
                static::REQUEST_INSTRUCTORS_KEY => [$invalidInstructorId]
            ]
        );
        $I->assertTrue($I->isResponseMatchingSchema(static::CREATE_PRO_CLASSROOM_SCHEMA_FILE));
    }

    /**
     * @group IntOnly
     */
    public function testCreateClassroomErrorInvalidCourseLanguage(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to create a classroom - invalid course language');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => 'API Automation Test Classroom (with unsupported language)',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::UNSUPPORTED_LANGUAGE,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 400);

        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    /**
     * @group IntOnly
     */
    public function testCreateClassroomErrorEmptyClassroomName(ApiTester $I)
    {
        $I->wantToTest('BusuuPRO - invalid request to create a classroom - empty classroom name');
        $I->login(Pro::ADMIN_EMAIL, Pro::ADMIN_PASSWORD, 200);

        $requestParams =
            [
                static::REQUEST_NAME_KEY => '',
                static::REQUEST_LANGUAGE_KEY => CourseLanguage::GERMAN,
                static::REQUEST_INSTRUCTORS_KEY => []
            ];

        $I->createProClassroom(Pro::INSTITUTION_ID, $requestParams, 400);

        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}