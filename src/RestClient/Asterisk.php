<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Helper;
use NgVoice\AriClient\Models\{AsteriskInfo,
    AsteriskPing,
    ConfigTuple,
    LogChannel,
    Model,
    Module,
    Variable};

/**
 * An implementation of the Asterisk REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Asterisk+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Asterisk extends AsteriskRestInterfaceClient
{
    /**
     * Retrieve a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic
     *     configuration objects.
     * @param string $objectType The type of configuration object to retrieve.
     * @param string $id The unique identifier of the object to retrieve.
     * @return ConfigTuple[]
     *
     * @throws AsteriskRestInterfaceException
     */
    public function getObject(string $configClass, string $objectType, string $id): array
    {
        return $this->getArrayOfModelInstancesRequest(
            ConfigTuple::class,
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
        );
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
     * @return ConfigTuple[]
     *
     * @throws AsteriskRestInterfaceException
     */
    public function updateObject(
        string $configClass,
        string $objectType,
        string $id,
        array $fields = []
    ): array {
        $body = ['fields' => []];

        if ($fields !== []) {
            $formattedFields = [];
            foreach ($fields as $attribute => $value) {
                $formattedFields[] = ['attribute' => $attribute, 'value' => $value];
            }
            $body['fields'] = $formattedFields;
        }

        return $this->putRequestReturningArrayOfModelInstances(
            ConfigTuple::class,
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            $body
        );
    }

    /**
     * Delete a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic
     *     configuration objects.
     * @param string $objectType The type of configuration object to delete.
     * @param string $id The unique identifier of the object to delete.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function deleteObject(
        string $configClass,
        string $objectType,
        string $id
    ): void {
        $this->deleteRequest(
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}"
        );
    }

    /**
     * Gets Asterisk system information.
     *
     * @param array $only Filter information returned. Allowed values: build, system,
     *     config, status.
     * @return AsteriskInfo|Model
     *
     * @throws AsteriskRestInterfaceException
     */
    public function getInfo(array $only = []): AsteriskInfo
    {
        $queryParameters = [];
        if ($only !== []) {
            $queryParameters = ['only' => Helper::glueArrayOfStrings($only)];
        }

        return $this->getModelRequest(
            AsteriskInfo::class,
            '/asterisk/info',
            $queryParameters
        );
    }

    /**
     * Response pong message.
     *
     * @return AsteriskPing|Model
     *
     * @throws AsteriskRestInterfaceException
     */
    public function ping(): AsteriskPing
    {
        return $this->getModelRequest(AsteriskPing::class, '/asterisk/ping');
    }

    /**
     * List Asterisk modules.
     *
     * @return Module[]
     *
     * @throws AsteriskRestInterfaceException
     */
    public function listModules(): array
    {
        return $this->getArrayOfModelInstancesRequest(
            Module::class,
            '/asterisk/modules'
        );
    }

    /**
     * Get Asterisk module information.
     *
     * @param string $moduleName Module's name.
     * @return Module|Model
     *
     * @throws AsteriskRestInterfaceException
     */
    public function getModule(string $moduleName): Module
    {
        return $this->getModelRequest(Module::class, "/asterisk/modules/{$moduleName}");
    }

    /**
     * Load an Asterisk module.
     *
     * @param string $moduleName Module's name.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function loadModule(string $moduleName): void
    {
        $this->postRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Unload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function unloadModule(string $moduleName): void
    {
        $this->deleteRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Reload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function reloadModule(string $moduleName): void
    {
        $this->putRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Gets Asterisk log channel information.
     *
     * @return LogChannel[]
     *
     * @throws AsteriskRestInterfaceException
     */
    public function listLogChannels(): array
    {
        return $this->getArrayOfModelInstancesRequest(
            LogChannel::class,
            'asterisk/logging'
        );
    }

    /**
     * Adds a log channel.
     *
     * @param string $logChannelName The log channel to add.
     * @param string $configuration Levels of the log channel
     *
     * @throws AsteriskRestInterfaceException
     */
    public function addLog(string $logChannelName, string $configuration): void
    {
        $this->postRequest(
            "/asterisk/logging/{$logChannelName}",
            ['configuration' => $configuration]
        );
    }

    /**
     * Deletes a log channel.
     *
     * @param string $logChannelName Log channels name.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function deleteLog(string $logChannelName): void
    {
        $this->deleteRequest("/asterisk/logging/{$logChannelName}");
    }

    /**
     * Rotates a log channel.
     *
     * @param string $logChannelName Log channel's name.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function rotateLog(string $logChannelName): void
    {
        $this->putRequest("/asterisk/logging/{$logChannelName}/rotate");
    }

    /**
     * Get the value of a global variable.
     *
     * @param string $variable The variable to get.
     * @return Variable|Model
     *
     * @throws AsteriskRestInterfaceException
     */
    public function getGlobalVar(string $variable): Variable
    {
        return $this->getModelRequest(
            Variable::class,
            '/asterisk/variable',
            ['variable' => $variable]
        );
    }

    /**
     * Set the value of a global variable.
     *
     * @param string $variable The variable to set.
     * @param string $value The value to set the variable to.
     *
     * @throws AsteriskRestInterfaceException
     */
    public function setGlobalVar(string $variable, string $value): void
    {
        $this->postRequest(
            '/asterisk/variable',
            ['variable' => $variable, 'value' => $value]
        );
    }
}
