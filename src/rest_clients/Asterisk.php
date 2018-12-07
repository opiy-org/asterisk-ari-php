<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use function AriStasisApp\{mapJsonArrayToAriObjects, glueArrayOfStrings, mapJsonToAriObject};
use AriStasisApp\models\{AsteriskInfo, ConfigTuple, LogChannel, Module, Variable};

/**
 * Class Asterisk
 *
 * @package AriStasisApp
 */
class Asterisk extends AriRestClient
{
    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @return ConfigTuple[]|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getObject(string $configClass, string $objectType, string $id): array
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}"),
            'AriStasisApp\models\ConfigTuple',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @param array $body The body object should have a value that is a list of ConfigTuples,
     * which provide the fields to update. Ex. [ { "attribute": "directmedia", "value": "false" } ]
     * @return ConfigTuple[]|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function createOrUpdateObject(string $configClass, string $objectType, string $id, ?array $body): array
    {
        $parsedBody = ['fields' => []];
        if (!is_null($body))
        {
            foreach ($body as $key => $value)
            {
                $parsedBody['fields'] = $parsedBody['fields'] + [['attribute' => $key, 'value' => $value]];
            }
        }

        return mapJsonArrayToAriObjects(
            $this->putRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}", $parsedBody),
            'AriStasisApp\models\ConfigTuple',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function deleteObject(string $configClass, string $objectType, string $id): void
    {
        $this->deleteRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}");
    }

    /**
     * Filter information returned
     * Allowed values: build, system, config, status
     * Allows comma separated values.
     * @param array $only
     * @return AsteriskInfo|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getInfo(array $only = []): AsteriskInfo
    {
        if ($only === []) {
            $response = $this->getRequest('/asterisk/info');
        } else {
            $only = glueArrayOfStrings($only);
            $response = $this->getRequest('/asterisk/info', ['only' => $only]);
        }

        return mapJsonToAriObject(
            $response,
            'AriStasisApp\models\AsteriskInfo',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @return Module[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listModules(): array
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest('/asterisk/modules'),
            'AriStasisApp\models\Module',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $moduleName
     * @return Module|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getModule(string $moduleName): Module
    {
        return mapJsonToAriObject(
            $this->getRequest("/asterisk/modules/{$moduleName}"),
            'AriStasisApp\models\Module',
            $this->jsonMapper,
            $this->logger
        );

    }

    /**
     * @param string $moduleName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function loadModule(string $moduleName): void
    {
        $this->postRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @param string $moduleName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unloadModule(string $moduleName): void
    {
        $this->deleteRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @param string $moduleName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function reloadModule(string $moduleName): void
    {
        $this->putRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @return LogChannel[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listLogChannels(): array
    {
        return mapJsonArrayToAriObjects(
            $this->getRequest('asterisk/logging'),
            'AriStasisApp\models\LogChannel',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $logChannelName
     * @param string $configuration Levels of the log channel
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function addLog(string $logChannelName, string $configuration): void
    {
        $this->postRequest("/asterisk/logging/{$logChannelName}", ['configuration' => $configuration]);
    }

    /**
     * @param string $logChannelName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function deleteLog(string $logChannelName): void
    {
        $this->deleteRequest("/asterisk/logging/{$logChannelName}");
    }

    /**
     * @param string $logChannelName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function rotateLog(string $logChannelName): void
    {
        $this->putRequest("/asterisk/logging/{$logChannelName}/rotate");
    }

    /**
     * @param string $variable
     * @return Variable|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getGlobalVar(string $variable): Variable
    {
        return mapJsonToAriObject(
            $this->getRequest('/asterisk/variable', ['variable' => $variable]),
            'AriStasisApp\models\Variable',
            $this->jsonMapper,
            $this->logger
        );
    }

    /**
     * @param string $variable
     * @param string $value
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function setGlobalVar(string $variable, string $value): void
    {
        $this->postRequest('/asterisk/variable', ['variable' => $variable, 'value' => $value]);
    }
}