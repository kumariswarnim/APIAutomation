<?php

namespace Tests\Api\Course;

use ApiTester;
use Helper\User;
use Helper\InterfaceLanguage;
use Helper\CourseLanguage;

class GetCourseStructureCest
{
    public function testGetCourseStructureSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET the course structure');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $interface_language = InterfaceLanguage::ENGLISH;
        $course = CourseLanguage::FRENCH;

        $I->getCourseStructure("/api/v2/course/$course?interface_language=$interface_language&translations=$course,$interface_language", 200);
        $I->assertTrue($I->isResponseMatchingSchema('course/getCourseStructure'));
    }

    public function testGetCourseStructureErrorInvalidCourse(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET the course structure - Invalid Course');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $interface_language = InterfaceLanguage::UNSUPPORTED_LANGUAGE;
        $course = CourseLanguage::UNSUPPORTED_LANGUAGE;

        $I->getCourseStructure("/api/v2/course/$course?interface_language=$interface_language&translations=$course,$interface_language", 400);
    }
}