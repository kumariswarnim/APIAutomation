<?php

namespace Module;

use Codeception\Module;
use JsonSchema\Validator;

abstract class AbstractModule extends Module
{
    protected function getRestModule()
    {
        return $this->getModule('REST');
    }

    /**
     * Checks whether a response matches its schema
     *
     * @param $schemaPath
     * @return bool
     */
    public function isResponseMatchingSchema($schemaPath)
    {
        $response = $this->getRestModule()->grabResponse();

        $validator = new Validator;

        $schema = file_get_contents(__DIR__ . '/../../schema/' . $schemaPath . '.json');
        $validator->check(json_decode($response), json_decode($schema));

        if (!$validator->isValid()) {
            $msg = '';
            foreach ($validator->getErrors() as $error) {
                $msg .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            $this->fail($msg);
        }
        return true;
    }

    protected function sendGetAndCheckResponse($url, $responseCode)
    {
        $this->getRestModule()->sendGET($url);
        $this->seeResponseCodeIs($responseCode);
    }

    protected function sendPostAndCheckResponse($url, $params = null, $responseCode)
    {
        $this->sendPostRequest($url, $params);
        $this->seeResponseCodeIs($responseCode);
    }

    protected function sendDeleteAndCheckResponse($url, $responseCode)
    {
        $this->sendDeleteRequest($url);
        $this->seeResponseCodeIs($responseCode);
    }

    private function sendPostRequest($url, $params = null)
    {
        $this->getRestModule()->sendPost($url, $params);
    }

    private function sendDeleteRequest($url, $params = null)
    {
        $this->getRestModule()->sendDelete($url, $params);
    }

    private function seeResponseCodeIs($responseCode)
    {
        $this->getRestModule()->seeResponseCodeIs($responseCode);
    }
}