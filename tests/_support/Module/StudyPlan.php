<?php

namespace Module;

class StudyPlan extends AbstractModule
{
    /**
     * Send a post request to estimate study plan and validates response code
     *
     * @param $learning_language
     * @param $motivation
     * @param $language
     * @param $goal_level
     * @param $learning_time
     * @param $minutes_day
     * @param $notifications
     * @param $learning_days
     * @param $responseCode
     */
    public function postStudyPlanEstimate($learning_language, $motivation, $language, $goal_level, $learning_time, $minutes_day, $notifications, $learning_days, $responseCode)
    {
        $this->sendPostAndCheckResponse("/study_plan/estimate?language=$learning_language", [
            'motivation' => $motivation,
            'language' => $language,
            'goal_level' => $goal_level,
            'learning_time' => $learning_time,
            'minutes_day' => $minutes_day,
            'notifications' => $notifications,
            'learning_days' => $learning_days
        ], $responseCode);
    }
}