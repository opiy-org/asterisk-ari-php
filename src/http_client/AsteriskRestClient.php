<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\http_client;

use function AriStasisApp\glueArrayOfStrings;

/**
 * Class AsteriskRestClient
 *
 * The details for all the REST calls can be found in the asterisk documentation.
 *
 * @package AriStasisApp
 */
class AsteriskRestClient extends AriRestClient
{
    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getObject(string $configClass, string $objectType, string $id)
    {
        return $this->getRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}");
    }

    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     *
     * The body object should have a value that is a list of ConfigTuples, which provide the fields to update.
     * Ex. [ { "attribute": "directmedia", "value": "false" } ]
     * @param array $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function createOrUpdateObject(string $configClass, string $objectType, string $id, array $body = [])
    {
        $parsedBody = ['fields' => []];
        if ($body === []) {
            foreach ($body as $key => $value) {
                $parsedBody['fields'] = array_merge($parsedBody['fields'], [['attribute' => $key, 'value' => $value]]);
            }
        }
        return $this->putRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}", $parsedBody);
    }

    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function deleteObject(string $configClass, string $objectType, string $id)
    {
        return $this->deleteRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}");
    }

    /**
     * Filter information returned
     * Allowed values: build, system, config, status
     * Allows comma separated values.
     * @param array $only
     *
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getInfo(array $only = [])
    {
        $only = glueArrayOfStrings($only);
        if (!empty($only)) {
            return $this->getRequest('/asterisk/info', ['only' => $only]);
        } else {
            return $this->getRequest('/asterisk/info');
        }
    }

    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function listModules()
    {
        return $this->getRequest('/asterisk/modules');
    }

    /**
     * @param string $moduleName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getModule(string $moduleName)
    {
        return $this->getRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @param string $moduleName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function loadModule(string $moduleName)
    {
        return $this->postRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @param string $moduleName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function unloadModule(string $moduleName)
    {
        return $this->deleteRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @param string $moduleName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function reloadModule(string $moduleName)
    {
        return $this->putRequest("/asterisk/modules/{$moduleName}");
    }

    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function listLogChannels()
    {
        return $this->getRequest('asterisk/logging');
    }

    /**
     * @param string $logChannelName
     * @param string $configuration Levels of the log channel
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function addLog(string $logChannelName, string $configuration)
    {
        return $this->postRequest("/asterisk/logging/{$logChannelName}", ['configuration' => $configuration]);
    }

    /**
     * @param string $logChannelName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function deleteLog(string $logChannelName)
    {
        return $this->deleteRequest("/asterisk/logging/{$logChannelName}");
    }

    /**
     * @param string $logChannelName
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function rotateLog(string $logChannelName)
    {
        return $this->putRequest("/asterisk/logging/{$logChannelName}/rotate");
    }

    /**
     * @param string $variable
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function getGlobalVar(string $variable)
    {
        return $this->getRequest('/asterisk/variable', ['variable' => $variable]);
    }

    /**
     * @param string $variable
     * @param string $value
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    function setGlobalVar(string $variable, string $value)
    {
        return $this->postRequest('/asterisk/variable', ['variable' => $variable, 'value' => $value]);
    }
}