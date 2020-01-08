<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\Bridge;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgeTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BridgeTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'bridge_class'    => 'ExampleClass',
        'bridge_type'     => 'mixing',
        'channels'        => [],
        'creator'         => 'ExampleCreator',
        'id'              => 'id1',
        'name'            => 'ExampleName',
        'technology'      => 'ExampleTechnology',
        'video_mode'      => 'none',
        'video_source_id' => 'VideoId',
        'creationtime'    => '2019-09-10 13:45:28 UTC',
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Bridge $bridge
         */
        $bridge = Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, new Bridge());

        $this->assertSame('ExampleName', $bridge->getName());
        $this->assertSame('id1', $bridge->getId());
        $this->assertSame('ExampleClass', $bridge->getBridgeClass());
        $this->assertSame('mixing', $bridge->getBridgeType());
        $this->assertSame([], $bridge->getChannels());
        $this->assertSame('ExampleCreator', $bridge->getCreator());
        $this->assertSame('ExampleTechnology', $bridge->getTechnology());
        $this->assertSame('none', $bridge->getVideoMode());
        $this->assertSame('VideoId', $bridge->getVideoSourceId());
        $this->assertSame('2019-09-10 13:45:28 UTC', $bridge->getCreationtime());
    }
}
