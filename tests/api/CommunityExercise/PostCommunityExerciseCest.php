<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\CourseLanguage;
use Helper\User;
use Helper\Exercise;

class PostCommunityExerciseCest
{
    /**
     * @group IntOnly
     */

    //TODO commenting this test as this test is not reliable, will fix this as a part of separate pr
//    public function testPostCommunityExerciseSuccess(ApiTester $I)
//    {
//        $I->wantToTest('valid request to POST a community exercise');
//
//        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);
//
//        $I->createCommunityExercise("/users/$uid/exercises", Exercise::INPUT, CourseLanguage::SPANISH, Exercise::RESOURCE_ID, Exercise::TYPE_WRITING, 200);
//        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/createExercise'));
//    }

    public function testPostCommunityExerciseEmptyLanguageError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a community exercise - missing language parameter');

        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);

        $I->createCommunityExercise("/users/$uid/exercises", Exercise::INPUT, null, Exercise::RESOURCE_ID, Exercise::TYPE_WRITING, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    public function testPostCommunityExerciseEmptyIdError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a community exercise - missing resource Id parameter');

        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);

        $I->createCommunityExercise("/users/$uid/exercises", Exercise::INPUT, CourseLanguage::SPANISH, null, Exercise::TYPE_WRITING, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    public function testPostCommunityExerciseEmptyTypeError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a community exercise - missing type parameter');

        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);

        $I->createCommunityExercise("/users/$uid/exercises", Exercise::INPUT, CourseLanguage::SPANISH, Exercise::RESOURCE_ID, null, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    public function testPostCommunityExerciseEmptyInputError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a community exercise - missing input parameter');

        $uid = $I->loginAndReturnUid(User::PREMIUM_EMAIL, User::PASSWORD);

        $I->createCommunityExercise("/users/$uid/exercises", null, CourseLanguage::SPANISH, Exercise::RESOURCE_ID_2, Exercise::TYPE_WRITING, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    public function testPostCommunityExerciseInvalidUserError(ApiTester $I)
    {
        $I->wantToTest('invalid request to POST a community exercise - invalid user id');
        $I->createCommunityExercise("/users/6578986543567/exercises", Exercise::INPUT, CourseLanguage::SPANISH, Exercise::RESOURCE_ID, Exercise::TYPE_WRITING, 401);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }
}