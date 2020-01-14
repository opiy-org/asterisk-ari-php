<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests;

use NgVoice\AriClient\Model\Message\Event\Event;
use Oktavlachs\DataMappingService\Collection\SourceNamingConventions;
use Oktavlachs\DataMappingService\DataMappingService;

/**
 * Class Helper
 *
 * @package NgVoice\AriClient\Tests
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Helper
{
    private static DataMappingService $dataMappingService;

    /**
     * Map an array onto an object.
     *
     * @param array $source The source to map from
     * @param object $target THe target to map onto
     *
     * @return object The mapped object
     */
    public static function mapOntoInstance(
        array $source,
        object $target
    ): object {
        if (!isset(self::$dataMappingService)) {
            self::$dataMappingService = new DataMappingService(
                SourceNamingConventions::LOWER_SNAKE_CASE
            );
            self::$dataMappingService
                ->setIsThrowingInvalidArgumentExceptionOnValidationError(true);
        }

        self::$dataMappingService->mapArrayOntoObject($source, $target);

        return $target;
    }

    /**
     * Map from an array onto an ARI event instance.
     *
     * @param string $eventType The target object type
     * @param array $eventAsArray The event in an array representation
     *
     * @return Event The mapped event
     */
    public static function mapOntoAriEvent(string $eventType, array $eventAsArray): Event
    {
        /** @var Event $result */
        $result = new $eventType();

        $shortClassName = substr($eventType, strrpos($eventType, "\\") + 1);

        $eventAsArray['type'] = $shortClassName;
        $eventAsArray['application'] = 'someApplication';
        $eventAsArray['timestamp'] = '2016-12-20 13:45:28 UTC';

        self::mapOntoInstance($eventAsArray, $result);

        return $result;
    }
}
