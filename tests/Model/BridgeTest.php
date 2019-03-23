<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\Bridge;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class BridgeTest
 *
 * @package NgVoice\AriClient\Tests\Model
 */
final class BridgeTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Bridge $bridge
         */
        $bridge = mapAriResponseParametersToAriObject(
            'Bridge',
            [
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
        );
        $this->assertSame('ExampleName', $bridge->getName());
        $this->assertSame('id1', $bridge->getId());
        $this->assertSame('ExampleClass', $bridge->getBridgeClass());
        $this->assertSame('mixing', $bridge->getBridgeType());
        $this->assertSame([], $bridge->getChannels());
        $this->assertSame('ExampleCreator', $bridge->getCreator());
        $this->assertSame('ExampleTechnology', $bridge->getTechnology());
        $this->assertSame('none', $bridge->getVideoMode());
        $this->assertSame('VideoId', $bridge->getVideoSourceId());
    }
}