<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\User;
use Helper\Exercise;

class GetCommunityExerciseCest
{
    public function testGetCommunityExerciseSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET a community exercise');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);

        $exerciseId = Exercise::COMMUNITY_EXERCISE_ID;

        $I->getCommunityExercises("/exercises/$exerciseId", 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/getExercise'));
    }

    public function testGetCommunityExerciseError(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET a community exercise - exercise id does not exist');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);

        $invalidExerciseId = Exercise::INVALID_COMMUNITY_EXERCISE_ID;

        $I->getCommunityExercises("/exercises/$invalidExerciseId", 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}