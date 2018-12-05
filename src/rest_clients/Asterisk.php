<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\rest_clients;

use AriStasisApp\models\{AsteriskInfo, Module, Variable};
use function AriStasisApp\glueArrayOfStrings;

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
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * TODO: "responseClass": "List[ConfigTuple]",
     */
    function getObject(string $configClass, string $objectType, string $id)
    {
        return $this->getRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}");
    }

    /**
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @param array $body The body object should have a value that is a list of ConfigTuples,
     * which provide the fields to update. Ex. [ { "attribute": "directmedia", "value": "false" } ]
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * TODO: "responseClass": "List[ConfigTuple]",
     */
    function createOrUpdateObject(string $configClass, string $objectType, string $id, array $body = [])
    {
        $parsedBody = ['fields' => []];
        if ($body === []) {
            foreach ($body as $key => $value) {
                $parsedBody['fields'] = $parsedBody['fields'] + [['attribute' => $key, 'value' => $value]];
            }
        }
        return $this->putRequest("/asterisk/config/dynamic/{$configClass}/{$objectType}/{$id}", $parsedBody);
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
     *
     * @return AsteriskInfo|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function getInfo(array $only = []): AsteriskInfo
    {
        if ($only !== []) {
            $only = glueArrayOfStrings($only);
            $response = $this->getRequest('/asterisk/info', ['only' => $only]);
        } else {
            $response = $this->getRequest('/asterisk/info');
        }

        return $this->jsonMapper->map(json_decode($response->getBody()), new AsteriskInfo());
    }

    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * TODO: "responseClass": "List[Module]",
     */
    function listModules()
    {
        return $this->getRequest('/asterisk/modules');
    }

    /**
     * @param string $moduleName
     * @return Module|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    function getModule(string $moduleName): Module
    {
        $response = $this->getRequest("/asterisk/modules/{$moduleName}");
        return $this->jsonMapper->map(json_decode($response->getBody()), new Module());
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
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * TODO: "responseClass": "List[LogChannel]"
     */
    function listLogChannels()
    {
        return $this->getRequest('asterisk/logging');
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
     * @throws \JsonMapper_Exception
     */
    function getGlobalVar(string $variable): Variable
    {
        $response = $this->getRequest('/asterisk/variable', ['variable' => $variable]);
        return $this->jsonMapper->map(json_decode($response->getBody()), new Variable());
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