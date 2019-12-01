<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Bridge, Message\BridgeMerged};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeMergedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class BridgeMergedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeMerged $bridgeMerged
         */
        $bridgeMerged = Helper::mapMessageParametersToAriObject(
            'BridgeMerged',
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
                ],
                'bridge_from' => [
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
        $this->assertInstanceOf(Bridge::class, $bridgeMerged->getBridge());
        $this->assertInstanceOf(Bridge::class, $bridgeMerged->getBridgeFrom());
    }
}
