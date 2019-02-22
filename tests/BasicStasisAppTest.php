<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/shared_test_functions.php';

use AriStasisApp\BasicStasisApp;
use AriStasisApp\rest_clients\{Applications,
    Asterisk,
    Bridges,
    Channels,
    DeviceStates,
    Endpoints,
    Events,
    Mailboxes,
    Playbacks,
    Recordings,
    Sounds};
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class BasicStasisAppTest
 *
 * @package AriStasisApp\Tests
 */
final class BasicStasisAppTest extends TestCase
{
    public function asteriskInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../environment.yaml');
        return [
            'setup basic stasis app' =>
                [new BasicStasisApp($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider asteriskInstanceProvider
     * @param BasicStasisApp $basicStasisApp
     */
    public function testGetter(BasicStasisApp $basicStasisApp): void
    {
        $this->assertInstanceOf(Channels::class, $basicStasisApp->getChannelsClient());
        $this->assertInstanceOf(Events::class, $basicStasisApp->getEventsClient());
        $this->assertInstanceOf(Asterisk::class, $basicStasisApp->getAsteriskClient());
        $this->assertInstanceOf(Applications::class, $basicStasisApp->getApplicationsClient());
        $this->assertInstanceOf(Bridges::class, $basicStasisApp->getBridgesClient());
        $this->assertInstanceOf(DeviceStates::class, $basicStasisApp->getDeviceStatesClient());
        $this->assertInstanceOf(Endpoints::class, $basicStasisApp->getEndpointsClient());
        $this->assertInstanceOf(Logger::class, $basicStasisApp->getLogger());
        $this->assertInstanceOf(Mailboxes::class, $basicStasisApp->getMailboxesClient());
        $this->assertInstanceOf(Playbacks::class, $basicStasisApp->getPlaybacksClient());
        $this->assertInstanceOf(Recordings::class, $basicStasisApp->getRecordingsClient());
        $this->assertInstanceOf(Sounds::class, $basicStasisApp->getSoundsClient());
    }
}