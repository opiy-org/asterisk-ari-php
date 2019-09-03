<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace AriStasisApp\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\Application;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationTest
 *
 * @package NgVoice\AriClient\Tests\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ApplicationTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Application $application
         */
        $application = Helper::mapAriResponseParametersToAriObject(
            'Application',
            [
                'name' => 'TestApplication',
                'channel_ids' => [],
                'endpoint_ids' => [],
                'bridge_ids' => [],
                'device_names' => [],
                'events_allowed' => [],
                'events_disallowed' => []
            ]
        );

        $this->assertSame('TestApplication', $application->getName());
        $this->assertSame([], $application->getChannelIds());
        $this->assertSame([], $application->getEndpointIds());
        $this->assertSame([], $application->getBridgeIds());
        $this->assertSame([], $application->getDeviceNames());
        $this->assertSame([], $application->getEventsAllowed());
        $this->assertSame([], $application->getEventsDisallowed());
    }
}
