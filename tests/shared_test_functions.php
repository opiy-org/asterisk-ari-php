<?php

namespace NgVoice\AriClient\Tests;

use JsonMapper;
use JsonMapper_Exception;
use NgVoice\AriClient\Model\Message\Message;
use NgVoice\AriClient\Model\Message\MissingParams;

/**
 * @param string $modelName
 * @param array $parameters
 * @return object
 * @throws JsonMapper_Exception
 */
function mapMessageParametersToAriObject(string $modelName, array $parameters)
{
    $parameters = $parameters + mockAsteriskId() + mockEventParameters() + ['type' => $modelName];
    $decodedJson = json_decode(json_encode($parameters));
    $eventPath = "NgVoice\\AriClient\\Model\\Message\\" . $modelName;
    $jsonMapper = new JsonMapper();
    $jsonMapper->bExceptionOnUndefinedProperty = true;
    $jsonMapper->bIgnoreVisibility = true;
    return $jsonMapper->map($decodedJson, new $eventPath);
}

/**
 * @return object
 * @throws JsonMapper_Exception
 */
function mapMessage()
{
    $parameters = ['type' => 'ExampleType'] + mockAsteriskId();
    $decodedJson = json_decode(json_encode($parameters));
    $jsonMapper = new JsonMapper();
    $jsonMapper->bExceptionOnUndefinedProperty = true;
    $jsonMapper->bIgnoreVisibility = true;
    return $jsonMapper->map($decodedJson, new Message());
}

/**
 * @return object
 * @throws JsonMapper_Exception
 * TODO: Cleanup the functions here (Duplicated code).
 */
function mapMissingParams()
{
    $parameters = [
            'params' => ['ExampleParam', 'ExampleParam2'],
            'type' => 'MissingParams'
        ] + mockAsteriskId();
    $decodedJson = json_decode(json_encode($parameters));
    $jsonMapper = new JsonMapper();
    $jsonMapper->bExceptionOnUndefinedProperty = true;
    $jsonMapper->bIgnoreVisibility = true;
    return $jsonMapper->map($decodedJson, new MissingParams());
}

/**
 * @param array $parameters
 * @param string $modelName
 * @return object
 * @throws JsonMapper_Exception
 */
function mapAriResponseParametersToAriObject(string $modelName, array $parameters)
{
    $decodedJson = json_decode(json_encode($parameters));
    $eventPath = "NgVoice\\AriClient\\Model\\" . $modelName;
    $jsonMapper = new JsonMapper();
    $jsonMapper->bExceptionOnUndefinedProperty = true;
    $jsonMapper->bIgnoreVisibility = true;
    return $jsonMapper->map($decodedJson, new $eventPath);
}

function mockAsteriskId()
{
    return ['asterisk_id' => '856134087103571'];
}

function mockEventParameters()
{
    return ['application' => 'SomeApplication', 'timestamp' => '2016-12-20 13:45:28 UTC'];
}