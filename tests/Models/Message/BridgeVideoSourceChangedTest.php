<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Bridge, Message\BridgeVideoSourceChanged};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeVideoSourceChangedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class BridgeVideoSourceChangedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeVideoSourceChanged $bridgeVideoSourceChanged
         */
        $bridgeVideoSourceChanged = Helper::mapMessageParametersToAriObject(
            'BridgeVideoSourceChanged',
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
                'old_video_source_id' => '15g5'
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeVideoSourceChanged->getBridge());
        $this->assertSame('15g5', $bridgeVideoSourceChanged->getOldVideoSourceId());
    }
}
