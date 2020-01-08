<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\{CallerID, Channel, DialplanCEP};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'name'         => 'SIP/foo-0000a7e3',
        'language'     => 'en',
        'accountcode'  => 'TestAccount',
        'channelvars'  => [
            'testVar'  => 'correct',
            'testVar2' => 'nope',
        ],
        'caller'       => [
            'name'   => 'ExampleName',
            'number' => 'ExampleNumber',
        ],
        'creationtime' => '2016-12-20 13:45:28 UTC',
        'state'        => 'Up',
        'connected'    => [
            'name'   => 'ExampleName2',
            'number' => 'ExampleNumber2',
        ],
        'dialplan'     => [
            'context'  => 'ExampleContext',
            'exten'    => 'ExampleExten',
            'app_data' => 'someAppData',
            'app_name' => 'SomeAppName',
            'priority' => 3,
        ],
        'id'           => '123456',
    ];

    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Channel $channel
         */
        $channel = Helper::mapOntoInstance(
            self::RAW_ARRAY_REPRESENTATION,
            new Channel()
        );
        $this->assertSame('SIP/foo-0000a7e3', $channel->getName());
        $this->assertSame('123456', $channel->getId());
        $this->assertSame('en', $channel->getLanguage());
        $this->assertObjectHasAttribute('testVar', $channel->getChannelvars());
        $this->assertSame('correct', $channel->getChannelvars()->testVar);
        $this->assertObjectHasAttribute('testVar2', $channel->getChannelvars());
        $this->assertSame('nope', $channel->getChannelvars()->testVar2);
        $this->assertSame('Up', $channel->getState());
        $this->assertInstanceOf(CallerID::class, $channel->getConnected());
        $this->assertInstanceOf(CallerID::class, $channel->getCaller());
        $this->assertSame('TestAccount', $channel->getAccountcode());
        $this->assertInstanceOf(DialplanCEP::class, $channel->getDialplan());
        $this->assertSame('2016-12-20 13:45:28 UTC', $channel->getCreationtime());
    }
}
