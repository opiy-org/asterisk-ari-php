<?php

namespace AriStasisApp\Tests;

use JsonMapper;
use JsonMapper_Exception;

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
    $eventPath = "AriStasisApp\\models\\messages\\" . $modelName;
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
    $eventPath = "AriStasisApp\\models\\messages\\Message";
    $jsonMapper = new JsonMapper();
    $jsonMapper->bExceptionOnUndefinedProperty = true;
    $jsonMapper->bIgnoreVisibility = true;
    return $jsonMapper->map($decodedJson, new $eventPath);
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
    $eventPath = "AriStasisApp\\models\\messages\\MissingParams";
    $jsonMapper = new JsonMapper();
    $jsonMapper->bExceptionOnUndefinedProperty = true;
    $jsonMapper->bIgnoreVisibility = true;
    return $jsonMapper->map($decodedJson, new $eventPath);
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
    $eventPath = "AriStasisApp\\models\\" . $modelName;
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