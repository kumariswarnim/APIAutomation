<?php

namespace Module;

class Course extends AbstractModule
{
    /**
     * Sends a get request to get the course structure and validates response code
     *
     * @param $url
     * @param $responseCode
     */
    public function getCourseStructure($url, $responseCode)
    {
        $this->sendGetAndCheckResponse($url, $responseCode);
    }

    /**
     * Sends a get request to get the component structure and validates response code
     *
     * @param $url
     * @param $responseCode
     */
    public function getComponentStructure($url, $responseCode)
    {
        $this->sendGetAndCheckResponse($url, $responseCode);
    }

    /**
     * Sends a get request to get the course progress and validates response code
     * @param $url
     * @param $responseCode
     */
    public function getCourseProgress($url, $responseCode)
    {
        $this->sendGetAndCheckResponse($url, $responseCode);
    }
}