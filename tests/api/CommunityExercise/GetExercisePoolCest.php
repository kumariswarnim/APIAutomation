<?php

namespace Tests\Api\CommunityExercise;

use ApiTester;
use Helper\CourseLanguage;
use Helper\User;
use Helper\Exercise;

class GetExercisePoolCest
{
    public function testGetExercisePoolSuccess(ApiTester $I)
    {
        $I->wantToTest('valid request to GET a list of community exercises to correct');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->getExercisePool(CourseLanguage::CHINESE, Exercise::LIMIT, 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/getExercisePool'));
    }

    //TODO - when we've done add-friend endpoint, change the hardcoded email to register, add friend, and then do the api call
    public function testGetExercisePoolFriendsOnlyExerciseToCorrect(ApiTester $I)
    {
        $I->wantToTest('valid request to GET a list of my friends\'s community exercises to correct');
        $I->login('swarnim@busuu.com', 'Uucplogn25', 200);
        $I->getFriendsExercisePool(CourseLanguage::SPANISH, Exercise::LIMIT, 200);
        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/getExercisePool'));
    }

    public function testGetExercisePoolInvalidLimitError(ApiTester $I)
    {
        $I->wantToTest('invalid request to GET a list of community exercises to correct - invalid limit');
        $I->login(User::FREE_EMAIL, User::PASSWORD, 200);
        $I->getExercisePool(CourseLanguage::SPANISH, -1, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/error'));
    }

    //TODO - when we've done add-friend endpoint, change this to register, add friend, and then do the api call
//    public function testGetExercisePoolFriendsOnlyNothingToCorrectSuccess(ApiTester $I)
//    {
//        $I->wantToTest('valid request to GET a list of my friends\'s community exercises to correct - no exercises to correct');
//        $I->login(User::HAS_MULTIPLE_FRIENDS_EMAIL, User::PASSWORD, 200);
//        $I->getFriendsExercisePool(CourseLanguage::ENGLISH, Exercise::LIMIT, 200);
//        $I->assertTrue($I->isResponseMatchingSchema('communityExercise/getExercisePool'));
//    }

    //TODO at some point - write test for invalid only_friends param. For now though, this will also return a 200 (and not 400)
}