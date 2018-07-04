<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\User;
use Helper\Exercise;

class PostThumbOnACorrectionOrACommentCest
{
    /**
     * @group IntOnly
     */
    public function testPostThumbUpOnACorrectionOrACommentSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to POST a thumb up rating on a correction or a comment');

        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $interactionId = Exercise::INTERACTION_ID;

        $I->thumbOnACorrectionOrAComment("/interactions/$interactionId/vote", 1, 200); //vote=1 means thumb up
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/voteOnCorrectionOrAComment'));
    }

    /**
     * @group IntOnly
     */
    public function testPostThumbDownOnACorrectionOrACommentSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to POST a thumb down rating on a correction or a comment');

        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $interactionId = Exercise::INTERACTION_ID;

        $I->thumbOnACorrectionOrAComment("/interactions/$interactionId/vote", 0, 200); //vote=0 means thumb down
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/voteOnCorrectionOrAComment'));
    }

    public function testPostThumbDownOnACorrectionOrACommentErrorInvalidParameter(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a thumb down rating on a correction or a comment - invalid vote parameter');

        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
        $interactionId = Exercise::INTERACTION_ID;

        $I->thumbOnACorrectionOrAComment("/interactions/$interactionId/vote", -1, 400); //vote=-1 means invalid vote
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    public function testPostThumbDownOnACorrectionOrACommentErrorInteractionNotFound(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a thumb down rating on a correction or a comment - interaction not found');

        $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);

        $I->thumbOnACorrectionOrAComment("/interactions/6/vote", 0, 404); //vote=0 means thumb down
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}