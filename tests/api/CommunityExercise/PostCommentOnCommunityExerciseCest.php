<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\User;
use Helper\Exercise;

class PostCommentOnCommunityExerciseCest
{
    /**
     * @group IntOnly
     */
    public function testPostCommentOnCommunityExerciseSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to POST a comment on community exercise');

        $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);
        $exerciseId = Exercise::COMMUNITY_EXERCISE_ID;

        $I->commentOnExercise("/exercises/$exerciseId/corrections", Exercise::BODY, Exercise::EXTRA_COMMENT, 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/exerciseInteraction'));
    }

    public function testPostCommentOnCommunityExerciseErrorExerciseNotFound(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a comment on community exercise - exercise not found');

        $I->loginAndReturnUid(User::FREE_EMAIL, User::PASSWORD);

        $I->commentOnExercise("/exercises/6/corrections", Exercise::BODY, Exercise::EXTRA_COMMENT, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}