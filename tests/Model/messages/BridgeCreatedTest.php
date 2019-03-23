<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Bridge, Message\BridgeCreated};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class BridgeCreatedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class BridgeCreatedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeCreated $bridgeCreated
         */
        $bridgeCreated = mapMessageParametersToAriObject(
            'BridgeCreated',
            [
                'bridge' => [
                    'bridge_class' => 'ExampleClass',
                    'bridge_type' => 'mixing',
                    'channels' => [],
                    'creator' => 'ExampleCreator',
                    'id' => 'id1',
                    'name' => 'ExampleName',
                    'technology' => 'ExampleTechnology',
                    'video_mode' => 'none',
                    'video_source_id' => 'VideoId'
                ]
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeCreated->getBridge());
    }
}