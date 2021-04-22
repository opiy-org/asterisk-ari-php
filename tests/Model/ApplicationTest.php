<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;

use OpiyOrg\AriClient\Model\Application;
use OpiyOrg\AriClient\Model\Message\Message;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ApplicationTest extends TestCase
{
    private Application $application;

    public function setUp(): void
    {
        $this->application = new Application();
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(Application::class, $this->application);
    }

    public function testSetAndGetName(): void
    {
        $name = 'someName';

        Helper::mapOntoInstance(['name' => $name], $this->application);

        $this->assertSame($name, $this->application->getName());
    }

    public function testSetAndGetChannelIds(): void
    {
        $channelIds = ['channelId1', 'channelId2'];

        Helper::mapOntoInstance(
            [
                'name'        => 'wurst',
                'channel_ids' => $channelIds,
            ],
            $this->application
        );

        $this->assertSame($channelIds, $this->application->getChannelIds());
    }

    public function testSetAndGetEndpointIds(): void
    {
        $endpointIds = ['endpointId1', 'endpointId2'];

        Helper::mapOntoInstance(
            [
                'name'         => 'wurst',
                'endpoint_ids' => $endpointIds,
            ],
            $this->application
        );
        $this->assertSame($endpointIds, $this->application->getEndpointIds());
    }

    public function testSetAndGetBridgeIds(): void
    {
        $bridgeIds = ['bridgeId1', 'bridgeId2'];

        Helper::mapOntoInstance(
            [
                'name'       => 'wurst',
                'bridge_ids' => $bridgeIds,
            ],
            $this->application
        );
        $this->assertSame($bridgeIds, $this->application->getBridgeIds());
    }

    public function testSetAndGetDeviceNames(): void
    {
        $deviceNames = ['deviceName1', 'deviceName2'];

        Helper::mapOntoInstance(
            [
                'name'         => 'wurst',
                'device_names' => $deviceNames,
            ],
            $this->application
        );
        $this->assertSame($deviceNames, $this->application->getDeviceNames());
    }

    public function testSetAndGetEventsAllowed(): void
    {
        $eventsAllowed = [
            ['type' => 'eventAllowed1'],
            ['type' => 'eventAllowed2'],
        ];
        Helper::mapOntoInstance(
            [
                'name'           => 'wurst',
                'events_allowed' => $eventsAllowed,
            ],
            $this->application
        );

        foreach ($this->application->getEventsAllowed() as $element) {
            $this->assertInstanceOf(Message::class, $element);
        }
    }

    public function testSetAndGetEventsDisallowed(): void
    {
        $eventsDisallowed = [
            ['type' => 'eventDisallowed1'],
            ['type' => 'eventDisallowed2'],
        ];

        Helper::mapOntoInstance(
            [
                'name'              => 'wurst',
                'events_disallowed' => $eventsDisallowed,
            ],
            $this->application
        );

        foreach ($this->application->getEventsDisallowed() as $element) {
            $this->assertInstanceOf(Message::class, $element);
        }
    }
}
