<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use OpiyOrg\AriClient\Model\Message\Event\Event;

/**
 * Class Helper
 *
 * @package OpiyOrg\AriClient\Tests
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Helper
{
    private static TreeMapper $dataMappingService;

    /**
     * Map from an array onto an ARI event instance.
     *
     * @param string $eventType The target object type
     * @param array $eventAsArray The event in an array representation
     *
     * @return Event The mapped event
     * @throws MappingError
     */
    public static function mapOntoAriEvent(string $eventType, array $eventAsArray): Event
    {
        /** @var Event $result */
        $result = new $eventType();

        $shortClassName = substr($eventType, strrpos($eventType, "\\") + 1);

        $eventAsArray['type'] = $shortClassName;
        $eventAsArray['application'] = 'someApplication';
        $eventAsArray['timestamp'] = '2016-12-20 13:45:28 UTC';

        return self::mapOntoInstance($eventAsArray, $result);
    }

    /**
     * Map an array onto an object.
     *
     * @param array $source The source to map from
     * @param object $target THe target to map onto
     *
     * @return mixed The mapped object
     * @throws MappingError
     */
    public static function mapOntoInstance(
        array $source,
        object $target
    ): object {
        if (!isset(self::$dataMappingService)) {
            self::$dataMappingService = (new MapperBuilder())
                ->enableFlexibleCasting()
                ->allowSuperfluousKeys()
                ->allowPermissiveTypes()
                ->mapper();
        }

        return self::$dataMappingService
            ->map($target::class, Source::array($source)->camelCaseKeys());
    }
}
