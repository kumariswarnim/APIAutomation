<?php

namespace Tests\Api\Referral;

use ApiTester;
use Helper\User;
use Helper\Api;
use Helper\CourseLanguage;

class GetReferralInfoCest
{
    public function testGetReferralInfoForPremiumUser(ApiTester $I)
    {
        $I->wantToTest("valid request to get referral info for premium user");
        $uid = $I->loginAndReturnUid(USER::PREMIUM_EMAIL, USER::PASSWORD);
        $I->getReferralInfo($uid, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferralInfoPremium'));
    }

    public function testGetReferralInfoForActiveUser(ApiTester $I)
    {
        $I->wantToTest("valid request to get referral info for active user");
        $uid = $I->loginAndReturnUid(USER::FREE_EMAIL, USER::PASSWORD);
        $I->getReferralInfo($uid, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferralInfoActive'));
    }

    /**
     * @group IntOnly
     */
    public function testGetReferralInfoForPremiumAdvocateUser(ApiTester $I)
    {
        $I->wantToTest("valid request to get referral info for premium advocate user");
        //Register a new user. Eventually this user will become advocate user.
        $advocateUserEmail = Api::generateRandomEmail();
        $advocateUsername = Api::generateRandomUsername();

        $advocateUserId = $I->registerAndReturnUid($advocateUsername, $advocateUserEmail, User::PASSWORD, CourseLanguage::ENGLISH, 200);
        //Get the referral code
        $referralCode = $I->getReferralCode($advocateUserId, 200);
        //Get how many users need to be invited & registered in order to get free premium membership
        $referral_threshold = $I->getReferralsThreshold($advocateUserId, 200);
        //Register new users using that referral code.
        for ($i = 0; $i < $referral_threshold; $i++) {
            $I->registerUsingReferralCodeAndReturnUid(User::USERNAME, Api::generateRandomEmail(), User::PASSWORD, CourseLanguage::ENGLISH, $referralCode, 200);
        }
        //Login using advocate user
        $advocateUserId = $I->loginAndReturnUid($advocateUserEmail, USER::PASSWORD);
        $I->getReferralInfo($advocateUserId, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferralInfoPremiumAdvocate'));
    }

    /**
     * @group IntOnly
     */
    public function testGetReferralInfoForPremiumReferredUser(ApiTester $I)
    {
        $I->wantToTest("valid request to get referral info for premium referred user");
        //Register a new user. Eventually this user will become advocate user.
        $advocateUsername = Api::generateRandomUsername();
        $advocateUserId = $I->registerAndReturnUid($advocateUsername, Api::generateRandomEmail(), User::PASSWORD, CourseLanguage::ENGLISH, 200);
        //Get the referral code
        $referralCode = $I->getReferralCode($advocateUserId, 200);
        //Register a new user using that referral code. This user will become premium referred user.
        $referredUserId = $I->registerUsingReferralCodeAndReturnUid(User::USERNAME, Api::generateRandomEmail(), User::PASSWORD, CourseLanguage::ENGLISH, $referralCode, 200);
        $I->getReferralInfo($referredUserId, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferralInfoPremiumReferred'));
    }

    public function testGetReferralInfoForExPremiumAdvocateUser(ApiTester $I)
    {
        $I->wantToTest("valid request to get referral info for premium advocate user after the free premium period end");
        $uid = $I->loginAndReturnUid(USER::PREMIUMADVOCATE_EMAIL, USER::PASSWORD);
        $I->getReferralInfo($uid, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferralInfoExPremiumAdvocate'));
    }

    public function testGetReferralInfoForExPremiumReferredUser(ApiTester $I)
    {
        $I->wantToTest("valid request to get referral info for premium referred user after the free premium period end");
        $uid = $I->loginAndReturnUid(USER::PREMIUMREFERRED_EMAIL, USER::PASSWORD);
        $I->getReferralInfo($uid, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferralInfoExPremiumReferred'));
    }

    public function testGetReferralInfoForUserWithoutAuthentication(ApiTester $I)
    {
        $I->wantToTest("invalid request to get referral info - invalid credential");
        $I->getReferralInfo(51657349, 401);
    }

    public function testGetReferralInfoForInvalidUser(ApiTester $I)
    {
        $I->wantToTest("invalid request to get referral info - invalid user");
        $I->getReferralInfo("a1b2c3d4", 404);
    }
}