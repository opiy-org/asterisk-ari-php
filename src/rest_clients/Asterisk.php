<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use AriStasisApp\models\{AsteriskInfo, ConfigTuple, LogChannel, Module, Variable};
use function AriStasisApp\glueArrayOfStrings;

/**
 * Class Asterisk
 *
 * @package AriStasisApp\rest_clients
 */
class Asterisk extends AriRestClient
{
    /**
     * Retrieve a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic configuration objects.
     * @param string $objectType The type of configuration object to retrieve.
     * @param string $id The unique identifier of the object to retrieve.
     * @return ConfigTuple[]|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getObject(string $configClass, string $objectType, string $id): array
    {
        return $this->getRequest(
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            [],
            'array',
            'ConfigTuple'
        );
    }

    /**
     * Create or update a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic configuration objects.
     * @param string $objectType The type of configuration object to create or update.
     * @param string $id The unique identifier of the object to create or update.
     * @param string[] $fields The body object should have a value that is a list of ConfigTuples,
     * which provide the fields to update.
     * @return ConfigTuple[]|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function updateObject(string $configClass, string $objectType, string $id, array $fields = []): array
    {
        $body = ['fields' => []];
        if ($fields !== []) {
            foreach ($fields as $attribute => $value) {
                $parsedBody['fields'] = $body['fields'] + [['attribute' => $attribute, 'value' => $value]];
            }
        }

        return $this->putRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            $body,
            'array',
            'ConfigTuple'
        );
    }

    /**
     * Delete a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic configuration objects.
     * @param string $objectType The type of configuration object to delete.
     * @param string $id The unique identifier of the object to delete.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function deleteObject(string $configClass, string $objectType, string $id): void
    {
        $this->deleteRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}");
    }

    /**
     * Gets Asterisk system information.
     *
     * @param array $only Filter information returned. Allowed values: build, system, config, status.
     * @return AsteriskInfo|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getInfo(array $only = []): AsteriskInfo
    {
        $queryParameters = [];
        if ($only !== []) {
            $queryParameters = ['only' => glueArrayOfStrings($only)];
        }
        return $this->getRequest('/asterisk/info', $queryParameters, 'model', 'AsteriskInfo');
    }

    /**
     * List Asterisk modules.
     *
     * @return Module[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listModules(): array
    {
        return $this->getRequest('/asterisk/modules', [], 'array', 'Module');
    }

    /**
     * Get Asterisk module information.
     *
     * @param string $moduleName Module's name.
     * @return Module|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getModule(string $moduleName): Module
    {
        return $this->getRequest("/asterisk/modules/{$moduleName}", [], 'model', 'Module');
    }

    /**
     * Load an Asterisk module.
     *
     * @param string $moduleName Module's name.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function loadModule(string $moduleName): void
    {
        $this->postRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Unload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unloadModule(string $moduleName): void
    {
        $this->deleteRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Reload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function reloadModule(string $moduleName): void
    {
        $this->putRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Gets Asterisk log channel information.
     *
     * @return LogChannel[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function listLogChannels(): array
    {
        return $this->getRequest('asterisk/logging', [], 'array', 'LogChannel');
    }

    /**
     * Adds a log channel.
     *
     * @param string $logChannelName The log channel to add.
     * @param string $configuration Levels of the log channel
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function addLog(string $logChannelName, string $configuration): void
    {
        $this->postRequest("/asterisk/logging/{$logChannelName}", ['configuration' => $configuration]);
    }

    /**
     * Deletes a log channel.
     *
     * @param string $logChannelName Log channels name.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function deleteLog(string $logChannelName): void
    {
        $this->deleteRequest("/asterisk/logging/{$logChannelName}");
    }

    /**
     * Rotates a log channel.
     *
     * @param string $logChannelName Log channel's name.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function rotateLog(string $logChannelName): void
    {
        $this->putRequest("/asterisk/logging/{$logChannelName}/rotate");
    }

    /**
     * Get the value of a global variable.
     *
     * @param string $variable The variable to get.
     * @return Variable|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function getGlobalVar(string $variable): Variable
    {
        return $this->getRequest('/asterisk/variable', ['variable' => $variable], 'model', 'Variable');
    }

    /**
     * Set the value of a global variable.
     *
     * @param string $variable The variable to set.
     * @param string $value The value to set the variable to.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function setGlobalVar(string $variable, string $value): void
    {
        $this->postRequest('/asterisk/variable', ['variable' => $variable, 'value' => $value]);
    }
}