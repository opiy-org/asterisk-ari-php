<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


use Monolog\Logger;
use NgVoice\AriClient\BasicStasisApp;
use NgVoice\AriClient\RestClient\{Applications,
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
use PHPUnit\Framework\TestCase;

/**
 * Class BasicStasisAppTest
 *
 * @package NgVoice\AriClient\Tests
 */
final class BasicStasisAppTest extends TestCase
{
    public function asteriskInstanceProvider(): array
    {
        return [
            'setup basic stasis app' =>
                [new BasicStasisApp('asterisk', 'asterisk')]
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

    public function testConstructor(): void
    {
        $this->assertInstanceOf(BasicStasisApp::class,
            new BasicStasisApp('asterisk', 'asterisk')
        );
    }
}