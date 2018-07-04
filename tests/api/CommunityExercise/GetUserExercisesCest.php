<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\CourseLanguage;
use Helper\User;
use Helper\Exercise;

class GetUserExercisesCest
{
    public function testGetAllExercisesForUserSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET all community exercises for a user');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $language = CourseLanguage::ENGLISH;
        $limit = Exercise::LIMIT;

        $I->getCommunityExercises("/users/$uid/exercises?languages=$language&limit=$limit", 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/getExercisesForSpecificUser'));
    }

    public function testGetAllExercisesForUserError(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET all community exercises for a user - language does not exist');
        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $language = 'a fake language';
        $limit = Exercise::LIMIT;

        $I->getCommunityExercises("/users/$uid/exercises?languages=$language&limit=$limit", 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}