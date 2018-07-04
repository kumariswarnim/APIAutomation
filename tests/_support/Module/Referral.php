<?php

namespace Module;

class Referral extends AbstractModule
{
    /**
     * Sends a get request with referral code to get the info about the referrer
     *
     * @param $referralCode
     * @param $responseCode
     */
    public function getReferrerInfoFromReferralCode($referralCode, $responseCode)
    {
        $this->sendGetAndCheckResponse("/anon/referrals/$referralCode", $responseCode);
    }

    /**
     * Send a get request with referrer uid to get the info about referral
     * @param $uid
     * @param $responseCode
     */
    public function getReferralInfo($uid, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid/referrals", $responseCode);
    }

    /**
     * Send a get request with referrer uid to get the referral code
     * @param $uid
     * @param $responseCode
     * @return string
     */
    public function getReferralCode($uid, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid/referrals", $responseCode);
        $referral_code_url =  $this->getRestModule()->grabDataFromResponseByJsonPath('$.data.referral_link')['0'];
        return substr($referral_code_url, strrpos($referral_code_url, '/') + 1);
    }

    /**
     * Send a get request with referrer uid to get the referrals threshold value
     * @param $uid
     * @param $responseCode
     * @return int
     */
    public function getReferralsThreshold($uid, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid/referrals", $responseCode);
        return  $this->getRestModule()->grabDataFromResponseByJsonPath('$.data.users_referred[0].referrals_threshold')['0'];
    }
}