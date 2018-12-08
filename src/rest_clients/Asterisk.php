<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use function AriStasisApp\glueArrayOfStrings;
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
        return $this->getRequest(
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            [],
            ['returnType' => 'array', 'modelClassName' => 'ConfigTuple']
        );
    }

    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @param string[] $body The body object should have a value that is a list of ConfigTuples,
     * which provide the fields to update.
     * @return ConfigTuple[]|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function updateObject(string $configClass, string $objectType, string $id, array $body = []): array
    {
        $parsedBody = ['fields' => []];
        if ($body !== [])
        {
            foreach ($body as $attribute => $value)
            {
                $parsedBody['fields'] = $parsedBody['fields'] + [['attribute' => $attribute, 'value' => $value]];
            }
        }

        return $this->putRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            $body,
            ['returnType' => 'array', 'modelClassName' => 'ConfigTuple']
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
     *
     * @param array $only
     * @return AsteriskInfo|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getInfo(array $only = []): AsteriskInfo
    {
        $queryParameters = [];
        if ($only !== []) {
            $queryParameters = ['only' => glueArrayOfStrings($only)];
        }
        return $this->getRequest(
            '/asterisk/info',
            $queryParameters,
            ['returnType' => 'model', 'modelClassName' => 'AsteriskInfo']
        );
    }

    /**
     * @return Module[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listModules(): array
    {
        return $this->getRequest(
            '/asterisk/modules',
            [],
            ['returnType' => 'array', 'modelClassName' => 'Module']
        );
    }

    /**
     * @param string $moduleName
     * @return Module|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getModule(string $moduleName): Module
    {
        return $this->getRequest(
            "/asterisk/modules/{$moduleName}",
            [],
            ['returnType' => 'model', 'modelClassName' => 'Module']
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
        return $this->getRequest(
            'asterisk/logging',
            [],
            ['returnType' => 'array', 'modelClassName' => 'LogChannel']
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
        return $this->getRequest(
            '/asterisk/variable',
            ['variable' => $variable],
            ['returnType' => 'model', 'modelClassName' => 'Variable']
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