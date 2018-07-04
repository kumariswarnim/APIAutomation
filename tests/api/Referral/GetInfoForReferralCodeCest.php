<?php

namespace Tests\Api\Referral;

use ApiTester;
use Helper\Referral;

class GetInfoForReferralCodeCest
{
    public function testGetReferralInvalidCode(ApiTester $I)
    {
        $I->wantToTest("invalid request to GET a referral code - invalid code");
        $I->getReferrerInfoFromReferralCode(Referral::INVALID_CODE, 404);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    /**
     * @group IntOnly
     */
    public function testGetReferralValidCode(ApiTester $I)
    {
        $I->wantToTest("valid request to GET a referral code - valid code");
        $I->getReferrerInfoFromReferralCode(Referral::INT_REFERRAL_CODE, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferrerInfo'));
    }

    /**
     * @group IntOnly
     */
    public function testGetReferralCodeAlreadyUsed(ApiTester $I)
    {
        $I->wantToTest("invalid request to GET a referral code - code already being used");
        $I->getReferrerInfoFromReferralCode(Referral::INT_USED_REFERRAL_CODE, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }

    /**
     * @group ProdOnly
     */
    public function testGetReferralValidCodeProd(ApiTester $I)
    {
        $I->wantToTest("valid request to GET a referral code - valid code");
        $I->getReferrerInfoFromReferralCode(Referral::PROD_REFERRAL_CODE, 200);
        $I->assertTrue($I->isResponseMatchingSchema('referral/getReferrerInfo'));
    }

    /**
     * @group ProdOnly
     */
    public function testGetReferralCodeAlreadyUsedProd(ApiTester $I)
    {
        $I->wantToTest("invalid request to GET a referral code - code already being used");
        $I->getReferrerInfoFromReferralCode(Referral::PROD_USED_REFERRAL_CODE, 400);
        $I->assertTrue($I->isResponseMatchingSchema('common/errorWithAppCode'));
    }
}