<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests;

use JsonMapper;
use JsonMapper_Exception;
use NgVoice\AriClient\Models\Message\{Message, MissingParams};

final class Helper
{
    /**
     * Constructor and clone are private because objects
     * of this class shouldn't be instantiated.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @param string $modelName
     * @param array $parameters
     *
     * @return Message|object
     *
     * @throws JsonMapper_Exception
     */
    public static function mapMessageParametersToAriObject(
        string $modelName,
        array $parameters
    ): Message {
        $parameters = $parameters
                      + self::mockAsteriskId()
                      + self::mockEventParameters()
                      + ['type' => $modelName];

        $decodedJson = json_decode(json_encode($parameters), false);
        $eventPath = "NgVoice\\AriClient\\Models\\Message\\{$modelName}";

        $jsonMapper = new JsonMapper();
        $jsonMapper->bExceptionOnUndefinedProperty = true;
        $jsonMapper->bIgnoreVisibility = true;

        return $jsonMapper->map($decodedJson, new $eventPath());
    }

    /**
     * @return Message|object
     *
     * @throws JsonMapper_Exception
     */
    public static function mapMessage(): Message
    {
        $parameters = ['type' => 'ExampleType'] + self::mockAsteriskId();
        $decodedJson = json_decode(json_encode($parameters), false);

        $jsonMapper = new JsonMapper();
        $jsonMapper->bExceptionOnUndefinedProperty = true;
        $jsonMapper->bIgnoreVisibility = true;

        return $jsonMapper->map($decodedJson, new Message());
    }

    /**
     * @return MissingParams|object
     *
     * @throws JsonMapper_Exception
     * TODO: Cleanup the functions here (Duplicated code).
     */
    public static function mapMissingParams(): MissingParams
    {
        $parameters = [
                          'params' => ['ExampleParam', 'ExampleParam2'],
                          'type'   => 'MissingParams',
                      ] + self::mockAsteriskId();

        $decodedJson = json_decode(json_encode($parameters), false);

        $jsonMapper = new JsonMapper();
        $jsonMapper->bExceptionOnUndefinedProperty = true;
        $jsonMapper->bIgnoreVisibility = true;

        return $jsonMapper->map($decodedJson, new MissingParams());
    }

    /**
     * @param array $parameters
     * @param string $modelName
     *
     * @return object
     *
     * @throws JsonMapper_Exception
     */
    public static function mapAriResponseParametersToAriObject(
        string $modelName,
        array $parameters
    ): object {
        $decodedJson = json_decode(json_encode($parameters), false);
        $eventPath = "NgVoice\\AriClient\\Models\\{$modelName}";

        $jsonMapper = new JsonMapper();
        $jsonMapper->bExceptionOnUndefinedProperty = true;
        $jsonMapper->bIgnoreVisibility = true;

        return $jsonMapper->map($decodedJson, new $eventPath());
    }

    private static function mockAsteriskId(): array
    {
        return ['asterisk_id' => '856134087103571'];
    }

    private static function mockEventParameters(): array
    {
        return [
            'application' => 'SomeApplication',
            'timestamp'   => '2016-12-20 13:45:28 UTC',
        ];
    }
}
