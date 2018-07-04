<?php

namespace Tests\Api\ProgressStats;

use ApiTester;
use Helper\User;
use Helper\CourseLanguage;

class GetProgressStatsCest
{
    public function testGetProgressStatsSuccess(ApiTester $I)
    {
        $I->wantToTest('valid GET request for Progress Stats for free user');
        $uid = $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);
        $courseLanguage = CourseLanguage::ENGLISH;
        $I->getProgressStats("/progress/users/$uid/stats?language=$courseLanguage", 200);
        $I->assertTrue($I->isResponseMatchingSchema('progressStats/getProgressStats'));
    }
    
    public function testGetProgressStatsSuccessPremiumUser(ApiTester $I)
    {
        $I->wantToTest('valid GET request for Progress Stats for premium user');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $courseLanguage = CourseLanguage::ENGLISH;
        $I->getProgressStats("/progress/users/$uid/stats?language=$courseLanguage", 200);
        $I->assertTrue($I->isResponseMatchingSchema('progressStats/getProgressStats'));
    }
    
    public function testGetProgressStatsSuccessWithTimezoneParameter(ApiTester $I)
    {
        $I->wantToTest('valid GET request for Progress Stats with additional "timezone" parameter');
        $uid = $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);
        $courseLanguage = CourseLanguage::ENGLISH;
        $timezone="%2B00:00";
        $I->getProgressStats("/progress/users/$uid/stats?language=$courseLanguage&$timezone", 200);
        $I->assertTrue($I->isResponseMatchingSchema('progressStats/getProgressStats'));
    }
    
    public function testGetProgressStatsBadRequest(ApiTester $I)
    {
        $I->wantToTest('invalid request to get Progress Stats - missing language');
        $uid = $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);
        $I->getProgressStats("/progress/users/$uid/stats?language=", 400);
        $I->assertTrue($I->isResponseMatchingSchema('progressStats/getProgressStatsBadRequestError'));
    }
    
    public function testGetProgressStatsAccessTokenInvalid(ApiTester $I)
    {
        $I->wantToTest('invalid request to get Progress Stats - user not logged in');
        $courseLanguage = CourseLanguage::ENGLISH;
        $I->getProgressStats("/progress/users/30416163/stats?language=$courseLanguage", 403);
        $I->assertTrue($I->isResponseMatchingSchema('progressStats/getProgressStatsInvalidAccessTokenError'));
    }

    public function testGetProgressStatsPageNotFound(ApiTester $I)
    {
        $I->wantToTest('invalid request to get Progress Stats - no user ID');
        $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);
        $courseLanguage = CourseLanguage::ENGLISH;
        $I->getProgressStats("/progress/users/stats?language=$courseLanguage", 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}