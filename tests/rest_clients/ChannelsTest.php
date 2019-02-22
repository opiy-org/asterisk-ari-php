<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 21.02.19
 * Time: 20:34
 */

namespace AriStasisApp\Tests\rest_clients;

use AriStasisApp\rest_clients\Channels;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class ChannelsTest extends TestCase
{
    public function channelsInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup channels client' =>
                [new Channels($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider channelsInstanceProvider
     */
    public function testContinueInDialPlan()
    {
    }

    public function testRecord()
    {

    }

    public function testSetChannelVar()
    {

    }

    public function testSnoopChannel()
    {

    }

    public function testRedirect()
    {

    }

    /**
     * @dataProvider channelsInstanceProvider
     * @param Channels $channels
     * @throws \ReflectionException
     */
    public function testList(Channels $channels)
    {
        $mock = $this->createMock(Channels::class);
        $mock->method('list')
            ->willReturn([]);
        $this->assertSame([], $mock->list());
    }

    public function testGetChannelVar()
    {

    }

    public function testMute()
    {

    }

    public function testStartSilence()
    {

    }

    public function testDial()
    {

    }

    public function testGet()
    {

    }

    public function testSendDtmf()
    {

    }

    public function testUnHold()
    {

    }

    public function testCreate()
    {

    }

    public function testStartMoh()
    {

    }

    public function testRing()
    {

    }

    public function testOriginate()
    {

    }

    public function testPlayWithId()
    {

    }

    public function testHold()
    {

    }

    public function testUnMute()
    {

    }

    public function testPlay()
    {

    }

    public function testOriginateWithId()
    {

    }

    public function testStopSilence()
    {

    }

    public function testStopMoh()
    {

    }

    public function testRingStop()
    {

    }

    public function testSnoopChannelWithId()
    {

    }

    public function testHangup()
    {

    }

    public function testAnswer()
    {

    }
}
