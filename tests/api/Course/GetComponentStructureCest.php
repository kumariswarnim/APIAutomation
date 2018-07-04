<?php

namespace Tests\Api\Course;

use ApiTester;
use Helper\User;
use Helper\InterfaceLanguage;
use Helper\CourseLanguage;

class GetComponentStructureCest
{
    public function testGetComponentStructureSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET the component structure');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $interface_language = InterfaceLanguage::ITALIAN;
        $course = CourseLanguage::GERMAN;

        $I->getComponentStructure("/api/v2/component/1_2_1_N?interfaceLanguage=$interface_language&lang1=$course&platform=web&translations=$course,$interface_language", 200);
        //$I->assertTrue($I->isResponseMatchingSchema('course/getComponentStructure'));
        // TODO - in Swarnim's PR comment - "I need to finish the component schema that I will do as a part of separate pr"
    }

    public function testGetComponentStructureErrorInvalidCourse(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET the component structure - Invalid component');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $interface_language = InterfaceLanguage::ITALIAN;
        $course = CourseLanguage::GERMAN;

        $I->getComponentStructure("/api/v2/component/unsupported?interfaceLanguage=$interface_language&lang1=$course&platform=web&translations=$course,$interface_language", 404);
    }
}