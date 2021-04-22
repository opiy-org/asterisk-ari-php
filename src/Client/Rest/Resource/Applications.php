<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Client\Rest\Resource;

use OpiyOrg\AriClient\Client\Rest\AbstractRestClient;
use OpiyOrg\AriClient\Enum\HttpMethods;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\Application;

/**
 * An implementation of the Applications REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Applications+REST+API
 *
 * @package OpiyOrg\AriClient\Client\Rest\Resource
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Applications extends AbstractRestClient
{
    /**
     * List all applications on the asterisk.
     *
     * @return array<int, Application>
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list(): array
    {
        $response = $this->sendRequest(HttpMethods::GET, '/applications');

        $applications = [];
        $this->responseToArrayOfAriModelInstances(
            $response,
            new Application(),
            $applications
        );

        return $applications;
    }

    /**
     * Get details of the application.
     *
     * @param string $applicationName Application's name.
     *
     * @return Application
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function get(string $applicationName): Application
    {
        $response = $this->sendRequest(
            HttpMethods::GET,
            "/applications/{$applicationName}"
        );

        $application = new Application();
        $this->responseToAriModelInstance($response, $application);

        return $application;
    }

    /**
     * Subscribe an application to a events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName Application's name.
     * @param array<int, string> $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}],
     *     deviceState:{deviceName}
     *
     * @return Application
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function subscribe(string $applicationName, array $eventSource): Application
    {
        $response = $this->sendRequest(
            HttpMethods::POST,
            "/applications/{$applicationName}/subscription",
            ['eventSource' => implode(',', $eventSource)]
        );

        $application = new Application();
        $this->responseToAriModelInstance($response, $application);

        return $application;
    }

    /**
     * Unsubscribe an application from an events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName Name of the target Stasis application
     * @param array<int, string> $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}],
     *     deviceState:{deviceName}
     *
     * @return Application
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function unsubscribe(string $applicationName, array $eventSource): Application
    {
        $response = $this->sendRequest(
            HttpMethods::DELETE,
            "/applications/{$applicationName}/subscription",
            ['eventSource' => implode(',', $eventSource)]
        );

        $application = new Application();
        $this->responseToAriModelInstance($response, $application);

        return $application;
    }

    /**
     * Filter application events types. Allowed and/or disallowed event type filtering
     * can be done. The body (parameter) should specify a JSON key/value object that
     * describes the type of event filtering needed. One, or both of the following keys
     * can be designated:
     *
     * "allowed" - Specifies an allowed list of event types
     * "disallowed" - Specifies a disallowed list of event types
     *
     * Further, each of those key's value should be a JSON array that holds zero, or more
     * JSON key/value objects. Each of these objects must contain the following key with
     * an associated value:
     * "type" - The type name of the event to filter
     *
     * The value must be the string name (case sensitive) of the event type that needs
     * filtering. For example:
     * { "allowed": [ { "type": "StasisStart" }, { "type": "StasisEnd" } ] }
     *
     * As this specifies only an allowed list, then only those two event type Event are
     * sent to the application. No other event Event are sent.
     *
     * The following rules apply:
     * - If the body is empty, both the allowed and disallowed filters are set empty.
     * - If both list types are given then both are set to their respective values
     *      (note, specifying an empty array for a given type sets that type to empty).
     * - If only one list type is given then only that type is set. The other type is not
     * updated.
     * - An empty "allowed" list means all events are allowed.
     * - An empty "disallowed" list means no events are disallowed.
     * - Disallowed events take precedence over allowed events if the event type is
     * specified in both lists.
     *
     * @param string $applicationName Application's name
     * @param string[]|null $allowed Specifies an allowed list of event types
     * @param string[]|null $disallowed Specifies a disallowed list of event types
     *
     * @return Application
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function filter(
        string $applicationName,
        ?array $allowed = null,
        ?array $disallowed = null
    ): Application {
        $body = [];

        if ($allowed !== null) {
            $body['allowed'] = $this->formatMessageTypesArray($allowed);
        }

        if ($disallowed !== null) {
            $body['disallowed'] = $this->formatMessageTypesArray($disallowed);
        }

        $response = $this->sendRequest(
            HttpMethods::PUT,
            "/applications/{$applicationName}/eventFilter",
            [],
            $body
        );

        $application = new Application();
        $this->responseToAriModelInstance($response, $application);

        return $application;
    }

    /**
     * @param string[] $messageTypes The types of messages that shall be formatted.
     *
     * @return array<int, array<string, string>>
     */
    private function formatMessageTypesArray(array $messageTypes): array
    {
        $messageTypesList = [];

        foreach ($messageTypes as $messageType) {
            $messageTypesList[] = ['type' => $messageType];
        }

        return $messageTypesList;
    }
}
