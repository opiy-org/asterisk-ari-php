<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\Application;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class ApplicationTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $application = mapAriResponseParametersToAriObject(
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