<?php

namespace Module;

class User extends AbstractModule
{
    /**
     * Sends a get request to retrieve a specific user's information, and validates response code
     *
     * @param $uid
     * @param $responseCode
     */
    public function getUserInfo($uid, $responseCode)
    {
        $this->sendGetAndCheckResponse("/users/$uid", $responseCode);
    }

    /**
     * Sends a post request to forgotten password and validates response code
     *
     * @param $email
     * @param $responseCode
     */
    public function postForgetPassword($email, $responseCode)
    {
        $this->sendPostAndCheckResponse('/anon/forgotten-password', ['email' => $email], $responseCode);
    }

    /**
     * Sends a post request to login and validates response code
     *
     * @param $email
     * @param $password
     * @param $responseCode
     */
    public function login($email, $password, $responseCode)
    {
        $this->sendPostAndCheckResponse('/anon/login', ['email' => $email, 'password' => $password], $responseCode);
    }

    /**
     * Sends a post request to register and validates response code
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $speaking_language
     * @param $responseCode
     */
    public function register($name, $email, $password, $speaking_language, $responseCode)
    {
        $this->sendPostAndCheckResponse('/anon/register', ['name' => $name, 'email' => $email, 'password' => $password, 'speaking_language' => $speaking_language], $responseCode);
    }

    /**
     * Sends a post request to register and validates response code
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $speaking_language
     * @param $referral_code
     * @param $responseCode
     */
    public function registerUsingReferralCode($name, $email, $password, $speaking_language, $referral_code, $responseCode)
    {
        $this->sendPostAndCheckResponse('/anon/register', ['name' => $name, 'email' => $email, 'password' => $password, 'speaking_language' => $speaking_language, 'referral_code' => $referral_code], $responseCode);
    }

    /**
     * Sends a post request to login and returns the uid from the response
     *
     * @param $email
     * @param $password
     * @return int
     */
    public function loginAndReturnUid($email, $password)
    {
        $this->sendPostAndCheckResponse('/anon/login', ['email' => $email, 'password' => $password], 200);
        return $this->getRestModule()->grabDataFromResponseByJsonPath('$.data.uid')['0'];
    }

    /**
     * Sends a post request to register and returns the uid from the response
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $speaking_language
     * @param $responseCode
     * @return int
     */
    public function registerAndReturnUid($name, $email, $password, $speaking_language, $responseCode)
    {
        $this->register($name, $email, $password, $speaking_language, $responseCode);
        return $this->getRestModule()->grabDataFromResponseByJsonPath('$.data.uid')['0'];
    }

    /**
     * Sends a post request to register and returns the uid from the response
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $speaking_language
     * @param $responseCode
     * @return int
     */
    public function registerUsingReferralCodeAndReturnUid($name, $email, $password, $speaking_language, $referral_code, $responseCode)
    {
        $this->registerUsingReferralCode($name, $email, $password, $speaking_language, $referral_code, $responseCode);
        return $this->getRestModule()->grabDataFromResponseByJsonPath('$.data.uid')['0'];
    }

}