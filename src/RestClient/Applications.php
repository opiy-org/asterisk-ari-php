<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\RestClient;

use NgVoice\AriClient\Exception\AsteriskRestInterfaceException;
use NgVoice\AriClient\Models\Application;

/**
 * An implementation of the Applications REST client for the
 * Asterisk REST Interface
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+Applications+REST+API
 *
 * @package NgVoice\AriClient\RestClient
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Applications extends AsteriskRestInterfaceClient
{
    /**
     * List all applications on the asterisk.
     *
     * @return Application[]
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function list()
    {
        /** @var Application[] $applications */
        $applications = $this->requestGetArrayOfModels(
            Application::class,
            '/applications'
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
        /** @var Application $application */
        $application = $this->getModelRequest(
            Application::class,
            "/applications/{$applicationName}"
        );

        return $application;
    }

    /**
     * Subscribe an application to a events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName Application's name.
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}],
     *     deviceState:{deviceName}
     *
     * @return Application
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function subscribe(string $applicationName, array $eventSource): Application
    {
        /** @var Application $application */
        $application = $this->postRequestReturningModel(
            Application::class,
            "/applications/{$applicationName}/subscription",
            ['eventSource' => implode(',', $eventSource)]
        );

        return $application;
    }

    /**
     * Unsubscribe an application from an events source.
     * Returns the state of the application after the subscriptions have changed.
     *
     * @param string $applicationName Name of the target Stasis application
     * @param array $eventSource URI for events source
     * (channel:{channelId}, bridge:{bridgeId}, endpoint:{tech}[/{resource}],
     *     deviceState:{deviceName}
     *
     * @return Application
     *
     * @throws AsteriskRestInterfaceException in case the REST request fails.
     */
    public function unsubscribe(string $applicationName, array $eventSource): Application
    {
        /** @var Application $application */
        $application = $this->deleteRequestReturningModel(
            Application::class,
            "/applications/{$applicationName}/subscription",
            ['eventSource' => implode(',', $eventSource)]
        );

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
     * As this specifies only an allowed list, then only those two event type Message are
     * sent to the application. No other event Message are sent.
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
        array $allowed = null,
        array $disallowed = null
    ): Application {
        $body = [];

        if ($allowed !== null) {
            $body['allowed'] = $this->formatMessageTypesArray($allowed);
        }

        if ($disallowed !== null) {
            $body['disallowed'] = $this->formatMessageTypesArray($disallowed);
        }

        /** @var Application $application */
        $application = $this->putRequestReturningModel(
            Application::class,
            "/applications/{$applicationName}/eventFilter",
            $body
        );

        return $application;
    }

    /**
     * @param string[] $messageTypes The types of messages that shall be formatted.
     *
     * @return string[]
     */
    private function formatMessageTypesArray(array $messageTypes)
    {
        $messageTypesList = [];

        foreach ($messageTypes as $messageType) {
            $messageTypesList[] = ['type' => $messageType];
        }

        return $messageTypesList;
    }
}
