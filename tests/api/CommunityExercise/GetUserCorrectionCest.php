<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\CourseLanguage;
use Helper\User;
use Helper\Exercise;

class GetUserCorrectionCest
{
    public function testGetAllCorrectionsForUserSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET all corrections for a user');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $language = CourseLanguage::ENGLISH;
        $limit = Exercise::LIMIT;

        $I->getCommunityExercises("/users/$uid/corrections?languages=$language&limit=$limit&offset=0&type=writing,picture,video,voice", 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/getCorrectionsForSpecificUser'));
    }

    public function testGetAllCorrectionsForUserErrorInvalidLanguage(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET all corrections for a user - language does not exist');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $language = 'a fake language';
        $limit = Exercise::LIMIT;

        $I->getCommunityExercises("/users/$uid/corrections?$language&limit=$limit&offset=0&type=writing,picture,video,voice", 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testGetAllCorrectionsForUserErrorUserNotExist(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET all corrections for a user - user does not exist');
        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $language = CourseLanguage::ENGLISH;
        $limit = Exercise::LIMIT;

        $I->getCommunityExercises("/users/-1/corrections?$language&limit=$limit&offset=0&type=writing,picture,video,voice", 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}