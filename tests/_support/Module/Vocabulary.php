<?php

namespace Module;

class Vocabulary extends AbstractModule
{
    /**
     * Sends a get request to retrieve the user vocabulary, and validates response code
     *
     * @param $url
     * @param $responseCode
     */
    public function getUserVocab($url, $responseCode)
    {
        $this->sendGetAndCheckResponse($url, $responseCode);
    }
}
