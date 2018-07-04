<?php

namespace Tests\Api\CourseProgress;

use ApiTester;
use Helper\User;
use Helper\CourseLanguage;

class GetCourseProgressCest
{
    public function testGetCourseProgressSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET the course progress');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $course = CourseLanguage::ENGLISH;

        $I->getCourseProgress("/api/v2/progress/$course", 200);
        $I->assertTrue($I->isResponseMatchingSchema('course/getCourseProgress'));
    }

    public function testGetCourseProgressErrorInvalidCourse(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET the course progress - invalid course');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $course = CourseLanguage::UNSUPPORTED_LANGUAGE;

        $I->getCourseProgress("/api/v2/progress/$course", 200);
        $I->assertTrue($I->isResponseMatchingSchema('course/getCourseProgress'));
    }
}