<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\User;
use Helper\Exercise;

class PostCommentOnACorrectionOrACommentCest
{
    /**
     * @group IntOnly
     */
    public function testPostCommentOnACorrectionOrACommentSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to POST a comment on a correction or a comment');

        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $interactionId = Exercise::INTERACTION_ID;

        $I->commentOnACorrectionOrAComment("/interactions/$interactionId/comments", Exercise::BODY, 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/exerciseInteraction'));
    }

    public function testPostCommentOnCommunityExerciseErrorInteractionNotFound(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a comment on a correction or a comment - interaction not found');

        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);

        $I->commentOnACorrectionOrAComment("/interactions/12/comments", Exercise::BODY, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}
