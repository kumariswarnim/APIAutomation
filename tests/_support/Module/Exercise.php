<?php

namespace Module;

use Helper\Exercise as ExerciseConstants;

class Exercise extends AbstractModule
{
    /**
     * Sends a post request to rate an exercise and validates response code
     *
     * @param $params
     * @param $responseCode
     */
    public function rateCommunityExercise($params, $responseCode)
    {
        $exerciseId = ExerciseConstants::USER_OWN_EXERCISE_ID;
        $this->sendPostAndCheckResponse("/exercises/$exerciseId/rate", $params, $responseCode);
    }

    /**
     * Sends a get request to retrieve either a specific community exercise, or multiple community exercises (for a specific user),
     * and then validates response code
     *
     * @param $url
     * @param $responseCode
     */
    public function getCommunityExercises($url, $responseCode)
    {
        $this->sendGetAndCheckResponse($url, $responseCode);
    }

    /**
     * Sends a get request to retrieve a list of exercises that can be corrected, and then validates response code
     *
     * @param $limit
     * @param $language
     * @param $responseCode
     */
    public function getExercisePool($language, $limit, $responseCode) {
        $this->sendGetAndCheckResponse("/exercises/pool?language=$language&limit=$limit", $responseCode);
    }

    /**
     * Sends a get request to retrieve a list of a user's friends' exercises that can be corrected, and then validates
     * response code
     *
     * @param $language
     * @param $limit
     * @param $responseCode
     */
    public function getFriendsExercisePool($language, $limit, $responseCode) {
        $this->sendGetAndCheckResponse("/exercises/pool?language=$language&limit=$limit&only_friends=true", $responseCode);
    }

    /**
     * Sends a post request to create a community exercise and validates response code
     *
     * @param $url
     * @param null $input
     * @param null $language
     * @param null $resourceId
     * @param null $type
     * @param $responseCode
     */
    public function createCommunityExercise($url, $input = null, $language = null, $resourceId = null, $type = null, $responseCode)
    {
        $this->sendPostAndCheckResponse($url, [
            'input' => $input,
            'language' => $language,
            'resource_id' => $resourceId,
            'type' => $type
        ], $responseCode);
    }

    /**
     * Sends a post request to comment on a community exercise and validates response code
     *
     * @param $url
     * @param null $body (body relates to the correction that the user writes)
     * @param null $extra_comment (extra_comment relates to the comment that the user writes)
     * @param $responseCode
     */
    public function commentOnExercise($url, $body = null, $extra_comment = null, $responseCode)
    {
        $this->sendPostAndCheckResponse($url, [
            'body' => $body,
            'extra_comment' => $extra_comment,
        ], $responseCode);
    }

    /**
     * Sends a post request to comment on a correction or a comment and validates response code
     *
     * @param $url
     * @param null $body (body relates to the correction that the user writes)
     * @param $responseCode
     */
    public function commentOnACorrectionOrAComment($url, $body = null, $responseCode)
    {
        $this->sendPostAndCheckResponse($url, [
            'body' => $body,
        ], $responseCode);
    }

    /**
     * Sends a post request to thumb on a correction or a comment and validates response code
     *
     * @param $url
     * @param $vote
     * @param $responseCode
     */
    public function thumbOnACorrectionOrAComment($url, $vote, $responseCode)
    {
        $this->sendPostAndCheckResponse($url, [
            'vote' => $vote,
        ], $responseCode);
    }
}