<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient\ResourceClient;

use NgVoice\AriClient\Collection\HttpMethods;
use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\{AsteriskInfo,
    AsteriskPing,
    ConfigTuple,
    LogChannel,
    Module,
    Variable};
use NgVoice\AriClient\RestClient\AbstractRestClient;

/**
 * An implementation of the Asterisk REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Asterisk+REST+API
 *
 * @package NgVoice\AriClient\RestClient\ResourceClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Asterisk extends AbstractRestClient
{
    /**
     * Retrieve a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic
     *     configuration objects.
     * @param string $objectType The type of configuration object to retrieve.
     * @param string $id The unique identifier of the object to retrieve.
     *
     * @return ConfigTuple[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function getObject(string $configClass, string $objectType, string $id)
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}"
        );

        /** @var ConfigTuple[] $configTuples */
        $configTuples = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new ConfigTuple(),
            $configTuples
        );

        return $configTuples;
    }

    /**
     * Create or update a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic
     *     configuration objects.
     * @param string $objectType The type of configuration object to create or update.
     * @param string $id The unique identifier of the object to create or update.
     * @param string[] $fields The body object should have a value that is a list of
     *     ConfigTuples, which provide the fields to update.
     *
     * @return ConfigTuple[]
     *
     * @throws AsteriskRestInterfaceException Default REST Interface Exception by Asterisk
     */
    public function updateObject(
        string $configClass,
        string $objectType,
        string $id,
        array $fields = []
    ) {
        $body = ['fields' => []];

        if ($fields !== []) {
            $formattedFields = [];

            foreach ($fields as $attribute => $value) {
                $formattedFields[] = ['attribute' => $attribute, 'value' => $value];
            }

            $body['fields'] = $formattedFields;
        }

        $response = $this->sendRequest(
            HttpMethods::PUT,
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            [],
            $body
        );

        /** @var ConfigTuple[] $configTuples */
        $configTuples = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new ConfigTuple(),
            $configTuples
        );

        return $configTuples;
    }

    /**
     * Delete a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic
     *     configuration objects.
     * @param string $objectType The type of configuration object to delete.
     * @param string $id The unique identifier of the object to delete.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function deleteObject(
        string $configClass,
        string $objectType,
        string $id
    ): void {
        $this->sendRequest(
            HttpMethods::DELETE,
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}"
        );
    }

    /**
     * Gets Asterisk system information.
     *
     * @param array $only Filter information returned. Allowed values: build, system,
     *     config, status.
     *
     * @return AsteriskInfo
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function getInfo(array $only = []): AsteriskInfo
    {
        $queryParameters = [];
        if ($only !== []) {
            $queryParameters = ['only' => implode(',', $only)];
        }

        $response = $this->sendRequest(
            HttpMethods::GET,
            '/asterisk/info',
            $queryParameters
        );

        $asteriskInfo = new AsteriskInfo();
        $this->responseToAriModelInstance($response, $asteriskInfo);

        return $asteriskInfo;
    }

    /**
     * Response pong message.
     *
     * @return AsteriskPing
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function ping(): AsteriskPing
    {
        $response = $this->sendRequest(HttpMethods::GET, '/asterisk/ping');

        $asteriskPing = new AsteriskPing();
        $this->responseToAriModelInstance($response, $asteriskPing);

        return $asteriskPing;
    }

    /**
     * List Asterisk modules.
     *
     * @return Module[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function listModules()
    {
        $response = $this->sendRequest(HttpMethods::GET, '/asterisk/modules');

        /** @var Module[] $modules */
        $modules = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new Module(),
            $modules
        );

        return $modules;
    }

    /**
     * Get Asterisk module information.
     *
     * @param string $moduleName Module's name.
     *
     * @return Module
     *
     * @throws AsteriskRestInterfaceException Default in case the REST request fails
     */
    public function getModule(string $moduleName): Module
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/asterisk/modules/{$moduleName}"
        );

        $module = new Module();
        $this->responseToAriModelInstance($response, $module);

        return $module;
    }

    /**
     * Load an Asterisk module.
     *
     * @param string $moduleName Module's name.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function loadModule(string $moduleName): void
    {
        $this->sendRequest(HttpMethods::POST, "/asterisk/modules/{$moduleName}");
    }

    /**
     * Unload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function unloadModule(string $moduleName): void
    {
        $this->sendRequest(HttpMethods::DELETE, "/asterisk/modules/{$moduleName}");
    }

    /**
     * Reload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function reloadModule(string $moduleName): void
    {
        $this->sendRequest(HttpMethods::PUT, "/asterisk/modules/{$moduleName}");
    }

    /**
     * Gets Asterisk log channel information.
     *
     * @return LogChannel[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function listLogChannels()
    {
        $response = $this->sendRequest(HttpMethods::GET, 'asterisk/logging');

        /** @var LogChannel[] $logChannels */
        $logChannels = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new LogChannel(),
            $logChannels
        );

        return $logChannels;
    }

    /**
     * Adds a log channel.
     *
     * @param string $logChannelName The log channel to add.
     * @param string $configuration Levels of the log channel
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function addLog(string $logChannelName, string $configuration): void
    {
        $this->sendRequest(
            HttpMethods::POST,
            "/asterisk/logging/{$logChannelName}",
            ['configuration' => $configuration]
        );
    }

    /**
     * Deletes a log channel.
     *
     * @param string $logChannelName Log channels name.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function deleteLog(string $logChannelName): void
    {
        $this->sendRequest(HttpMethods::DELETE, "/asterisk/logging/{$logChannelName}");
    }

    /**
     * Rotates a log channel.
     *
     * @param string $logChannelName Log channel's name.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function rotateLog(string $logChannelName): void
    {
        $this->sendRequest(
            HttpMethods::PUT,
            "/asterisk/logging/{$logChannelName}/rotate"
        );
    }

    /**
     * Get the value of a global variable.
     *
     * @param string $variable The variable to get.
     *
     * @return Variable
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function getGlobalVar(string $variable): Variable
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            '/asterisk/variable',
            ['variable' => $variable]
        );

        $variable = new Variable();
        $this->responseToAriModelInstance($response, $variable);

        return $variable;
    }

    /**
     * Set the value of a global variable.
     *
     * @param string $variable The variable to set.
     * @param string $value The value to set the variable to.
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails
     */
    public function setGlobalVar(string $variable, string $value): void
    {
        $this->sendRequest(
            HttpMethods::POST,
            '/asterisk/variable',
            ['variable' => $variable, 'value' => $value]
        );
    }
}
