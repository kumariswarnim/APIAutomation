<?php
namespace Tests\Api\StudyPlan;

use ApiTester;
use Helper\CourseLanguage;
use Helper\User;

class PostStudyPlanEstimateCest
{
    public function testPostStudyPlanEstimateSuccess(ApiTester $I)
    {
        $I->wantToTest('valid POST request to estimate study plan');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::SPANISH,"travel", CourseLanguage::SPANISH, "a2", "11:30", 30, 0, [0,0,0,0,0,1,0], 200);
        $I->assertTrue($I->isResponseMatchingSchema('studyPlan/postStudyPlanEstimate'));
    }

    public function testPostStudyPlanEstimateErrorInvalidAccess(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid access token');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::SPANISH, "travel", CourseLanguage::SPANISH, "a1", "11:30", 15, 0, [0, 0, 0, 0, 0, 1, 0], 403);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorUnableToCreateStudyPlan(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - unable to create study plan');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::ENGLISH, "travel", CourseLanguage::UNSUPPORTED_LANGUAGE, "a1", "11:30", 15, 0, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorInvalidMotivation(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid motivation');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::GERMAN, null, CourseLanguage::GERMAN, "a1", "11:30", 15, 0, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorEmptyLanguage(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - empty language');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::ENGLISH,"travel", null, "a1", "11:30", 15, 0, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorInvalidGoalLevel(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid goal level');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::FRENCH,"travel", CourseLanguage::FRENCH, "invalidGoal", "11:30", 15, 0, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorInvalidLearningTime(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid learning time');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::PORTUGUESE,"travel", CourseLanguage::PORTUGUESE, "a1", "invalidTime", 15, 0, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorInvalidLearningDays(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid learning days');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::ITALIAN,"travel", CourseLanguage::ITALIAN, "a1", "11:00", 15, 0, [0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorInvalidNotifications(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid notifications');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::ENGLISH,"travel", CourseLanguage::ENGLISH, "a1", "11:00", 15, null, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostStudyPlanEstimateErrorInvalidMinutesPerDay(ApiTester $I)
    {
        $I->wantToTest('invalid POST request to estimate study plan - invalid minutes per day');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->postStudyPlanEstimate(CourseLanguage::GERMAN,"travel", CourseLanguage::GERMAN, "a1", "11:30", 31788576, 0, [0,0,0,0,0,1,0], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}