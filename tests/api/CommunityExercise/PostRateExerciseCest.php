<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\User;

class PostRateExerciseCest
{
    /**
     * @group IntOnly
     */
    public function testUserRatesExerciseSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to POST a star rating to an exercise');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->rateCommunityExercise(['rate' => 1], 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/rateExercise'));
    }

    /**
     * @group IntOnly
     */
    public function testUserRatesOwnExerciseError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a star rating to an exercise - user cannot rate own exercise');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->rateCommunityExercise(['rate' => 1], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testUserRatesExerciseTooHighError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a star rating to an exercise - user cannot rate higher than 5');
        $I->login(User::PREMIUM_EMAIL, User::PASSWORD, 200);
        $I->rateCommunityExercise(['rate' => 6], 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}