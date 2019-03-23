<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use NgVoice\AriClient\Model\{Bridge, Message\BridgeVideoSourceChanged};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class BridgeVideoSourceChangedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class BridgeVideoSourceChangedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeVideoSourceChanged $bridgeVideoSourceChanged
         */
        $bridgeVideoSourceChanged = mapMessageParametersToAriObject(
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