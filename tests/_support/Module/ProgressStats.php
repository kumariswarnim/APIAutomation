<?php

namespace Module;

class ProgressStats extends AbstractModule
{
    /**
     * Sends a get request to get the info about the progress stats
     *
     * @param $url
     * @param $responseCode
     */
    public function getProgressStats($url, $responseCode)
    {
        $this->sendGetAndCheckResponse($url, $responseCode);
    }
}