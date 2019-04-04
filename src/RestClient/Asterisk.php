<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\RestClient;

use GuzzleHttp\Exception\GuzzleException;
use NgVoice\AriClient\Model\{AsteriskInfo, AsteriskPing, ConfigTuple, LogChannel, Module, Variable};
use function NgVoice\AriClient\glueArrayOfStrings;

/**
 * Class Asterisk
 * @package NgVoice\AriClient\RestClient
 */
final class Asterisk extends AriRestClient
{
    /**
     * Retrieve a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic configuration objects.
     * @param string $objectType The type of configuration object to retrieve.
     * @param string $id The unique identifier of the object to retrieve.
     * @return ConfigTuple[]|object
     * @throws GuzzleException
     */
    public function getObject(string $configClass, string $objectType, string $id): array
    {
        return $this->getRequest(
            "/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            [],
            parent::ARRAY,
            ConfigTuple::class
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
     * @throws GuzzleException
     */
    public function updateObject(string $configClass, string $objectType, string $id, array $fields = []): array
    {
        $body = ['fields' => []];

        if ($fields !== []) {
            $formattedFields = [];
            foreach ($fields as $attribute => $value) {
                $formattedFields[] = ['attribute' => $attribute, 'value' => $value];
            }
            $body['fields'] = $formattedFields;
        }

        return $this->putRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}",
            $body,
            parent::ARRAY,
            ConfigTuple::class
        );
    }

    /**
     * Delete a dynamic configuration object.
     *
     * @param string $configClass The configuration class containing dynamic configuration objects.
     * @param string $objectType The type of configuration object to delete.
     * @param string $id The unique identifier of the object to delete.
     * @throws GuzzleException
     */
    public function deleteObject(string $configClass, string $objectType, string $id): void
    {
        $this->deleteRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}");
    }

    /**
     * Gets Asterisk system information.
     *
     * @param array $only Filter information returned. Allowed values: build, system, config, status.
     * @return AsteriskInfo|object
     * @throws GuzzleException
     */
    public function getInfo(array $only = []): AsteriskInfo
    {
        $queryParameters = [];
        if ($only !== []) {
            $queryParameters = ['only' => glueArrayOfStrings($only)];
        }
        return $this->getRequest('/asterisk/info', $queryParameters, parent::MODEL, AsteriskInfo::class);
    }

    /**
     * Response pong message.
     *
     * @return AsteriskPing|object
     * @throws GuzzleException
     */
    public function ping(): AsteriskPing
    {
        return $this->getRequest('/asterisk/ping', [], parent::MODEL, AsteriskPing::class);
    }

    /**
     * List Asterisk modules.
     *
     * @return Module[]
     * @throws GuzzleException
     */
    public function listModules(): array
    {
        return $this->getRequest('/asterisk/modules', [], parent::ARRAY, Module::class);
    }

    /**
     * Get Asterisk module information.
     *
     * @param string $moduleName Module's name.
     * @return Module|object
     * @throws GuzzleException
     */
    public function getModule(string $moduleName): Module
    {
        return $this->getRequest("/asterisk/modules/{$moduleName}", [], parent::MODEL, Module::class);
    }

    /**
     * Load an Asterisk module.
     *
     * @param string $moduleName Module's name.
     * @throws GuzzleException
     */
    public function loadModule(string $moduleName): void
    {
        $this->postRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Unload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     * @throws GuzzleException
     */
    public function unloadModule(string $moduleName): void
    {
        $this->deleteRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Reload an Asterisk module.
     *
     * @param string $moduleName Module's name.
     * @throws GuzzleException
     */
    public function reloadModule(string $moduleName): void
    {
        $this->putRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * Gets Asterisk log channel information.
     *
     * @return LogChannel[]
     * @throws GuzzleException
     */
    public function listLogChannels(): array
    {
        return $this->getRequest('asterisk/logging', [], parent::ARRAY, LogChannel::class);
    }

    /**
     * Adds a log channel.
     *
     * @param string $logChannelName The log channel to add.
     * @param string $configuration Levels of the log channel
     * @throws GuzzleException
     */
    public function addLog(string $logChannelName, string $configuration): void
    {
        $this->postRequest("/asterisk/logging/{$logChannelName}", ['configuration' => $configuration]);
    }

    /**
     * Deletes a log channel.
     *
     * @param string $logChannelName Log channels name.
     * @throws GuzzleException
     */
    public function deleteLog(string $logChannelName): void
    {
        $this->deleteRequest("/asterisk/logging/{$logChannelName}");
    }

    /**
     * Rotates a log channel.
     *
     * @param string $logChannelName Log channel's name.
     * @throws GuzzleException
     */
    public function rotateLog(string $logChannelName): void
    {
        $this->putRequest("/asterisk/logging/{$logChannelName}/rotate");
    }

    /**
     * Get the value of a global variable.
     *
     * @param string $variable The variable to get.
     * @return Variable|object
     * @throws GuzzleException
     */
    public function getGlobalVar(string $variable): Variable
    {
        return $this->getRequest('/asterisk/variable', ['variable' => $variable], parent::MODEL, Variable::class);
    }

    /**
     * Set the value of a global variable.
     *
     * @param string $variable The variable to set.
     * @param string $value The value to set the variable to.
     * @throws GuzzleException
     */
    public function setGlobalVar(string $variable, string $value): void
    {
        $this->postRequest('/asterisk/variable', ['variable' => $variable, 'value' => $value]);
    }
}