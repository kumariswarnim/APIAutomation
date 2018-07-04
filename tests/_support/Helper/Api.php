<?php

namespace Helper;

/*
 * Only put simple functions in here - do not put any business logic in this class (should go into a Module instead)
 */

class Api
{
    /**
     * Generate a random email
     */
    public static function generateRandomEmail()
    {
        $randomNumber = md5(uniqid(rand(), true));
        $emailAddress = "qa+{$randomNumber}@busuu.com";
        return $emailAddress;
    }

    /**
     * Generate a random username
     */
    public static function generateRandomUsername()
    {
        $randomNumber = md5(uniqid(rand(), true));
        $username = User::USERNAME."{$randomNumber}";
        return substr($username,0,30);
    }
}
