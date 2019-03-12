<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\RestClient;


use AriStasisApp\Model\Application;
use function AriStasisApp\glueArrayOfStrings;

/**
 * Class Applications
 *
 * @package AriStasisApp\ariclients
 */
class Applications extends AriRestClient
{
    private const APPLICATION = 'Application';

    /**
     * List all applications on the asterisk.
     *
     * @return Application[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function list(): array
    {
        return $this->getRequest('/applications', [], 'array', self::APPLICATION);
    }

    /**
     * Get details of the application.
     *
     * @param string $applicationName Application's name.
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function get(string $applicationName): Application
    {
        return $this->getRequest("/applications/{$applicationName}", [], self::MODEL, self::APPLICATION);
    }

    /**
     * Subscribe an application to a events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName Application's name.
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function subscribe(string $applicationName, array $eventSource): Application
    {
        return $this->postRequest(
            "/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)],
            [],
            self::MODEL,
            self::APPLICATION
        );
    }

    /**
     * Unsubscribe an application from an events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}], deviceState:{deviceName}
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function unsubscribe(string $applicationName, array $eventSource): Application
    {
        return $this->deleteRequest(
            "/applications/{$applicationName}/subscription",
            ['eventSource' => glueArrayOfStrings($eventSource)],
            self::MODEL,
            self::APPLICATION
        );
    }

    /**
     * Filter application events types. Allowed and/or disallowed event type filtering can be done.
     * The body (parameter) should specify a JSON key/value object that describes the type of event filtering needed.
     * One, or both of the following keys can be designated:
     *
     * "allowed" - Specifies an allowed list of event types
     * "disallowed" - Specifies a disallowed list of event types
     *
     * Further, each of those key's value should be a JSON array that holds zero, or more JSON key/value objects.
     * Each of these objects must contain the following key with an associated value:
     * "type" - The type name of the event to filter
     *
     * The value must be the string name (case sensitive) of the event type that needs filtering. For example:
     * { "allowed": [ { "type": "StasisStart" }, { "type": "StasisEnd" } ] }
     *
     * As this specifies only an allowed list, then only those two event type Message are sent to the application.
     * No other event Message are sent.
     *
     * The following rules apply:
     * - If the body is empty, both the allowed and disallowed filters are set empty.
     * - If both list types are given then both are set to their respective values
     *      (note, specifying an empty array for a given type sets that type to empty).
     * - If only one list type is given then only that type is set. The other type is not updated.
     * - An empty "allowed" list means all events are allowed.
     * - An empty "disallowed" list means no events are disallowed.
     * - Disallowed events take precedence over allowed events if the event type is specified in both lists.
     *
     * @param string $applicationName Application's name
     * @param array $allowed Specifies an allowed list of event types
     * @param array $disallowed Specifies a disallowed list of event types
     *
     * @return Application|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function filter(string $applicationName, array $allowed = null, array $disallowed = null): Application
    {
        $body = [];

        if ($allowed !== null) {
            $body['allowed'] = $this->formatMessageTypesArray($allowed);
        }

        if ($disallowed !== null) {
            $body['disallowed'] = $this->formatMessageTypesArray($disallowed);
        }

        return $this->putRequest("/applications/{$applicationName}/eventFilter", $body, self::MODEL, self::APPLICATION);
    }

    /**
     * @param array $messageTypes
     * @return array
     */
    private function formatMessageTypesArray(array $messageTypes)
    {
        $messageTypesList = [];

        for ($i = 0; $i < sizeof($messageTypes); $i++) {
            $messageTypesList[$i] = ['type' => $messageTypes[$i]];
        }

        return $messageTypesList;
    }
}