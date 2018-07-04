<?php

namespace Tests\Api\User;

use ApiTester;
use Helper\User;
use Helper\InterfaceLanguage;
use Helper\CourseLanguage;

class GetUserVocabularyCest
{
    public function testGetUserAllVocabularySuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET user all vocab');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $course = CourseLanguage::ENGLISH;

        $I->getUserVocab("/vocabulary/all/$course?translations=$course,de", 200);
        $I->assertTrue($I->isResponseMatchingSchema('vocab/getUserVocab'));
    }

    public function testGetUserSavedVocabularySuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET user saved vocab');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $course = CourseLanguage::ENGLISH;

        $I->getUserVocab("/vocabulary/saved/$course?translations=$course,de", 200);
        $I->assertTrue($I->isResponseMatchingSchema('vocab/getUserVocab'));
    }

    public function testGetUserSeenVocabularySuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET user seen vocab');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $course = CourseLanguage::ENGLISH;

        $I->getUserVocab("/vocabulary/see/$course?translations=$course,de", 200);
        $I->assertTrue($I->isResponseMatchingSchema('vocab/getUserVocab'));
    }

    public function testGetUserVocabularyErrorInvalidAccessToken(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET user vocab - invalid access token');
        $course = CourseLanguage::ENGLISH;

        $I->getUserVocab("/vocabulary/see/$course?translations=$course,de", 403);
        $I->assertTrue($I->isResponseMatchingSchema('vocab/getUserVocabError'));
    }

    public function testGetUserVocabularyErrorInvalidCourse(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET user vocab - invalid course');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $course = CourseLanguage::UNSUPPORTED_LANGUAGE;

        $I->getUserVocab("/vocabulary/see/$course?translations=$course,de", 400);
        $I->seeResponseContains('Invalid language');
    }
}