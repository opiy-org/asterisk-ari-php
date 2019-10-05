<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\Channel;
use NgVoice\AriClient\Models\ExternalMedia;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ExternalMediaTest
 *
 * @package NgVoice\AriClient\Tests\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ExternalMediaTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ExternalMedia $externalMedia
         */
        $externalMedia = Helper::mapAriResponseParametersToAriObject(
            'ExternalMedia',
            [
                'local_address' => '127.0.0.1',
                'channel' => [
                    'name' => 'SIP/foo-0000a7e3',
                    'language' => 'en',
                    'accountcode' => 'TestAccount',
                    'channelvars' => [
                        'testVar' => 'correct',
                        'testVar2' => 'nope',
                    ],
                    'caller' => [
                        'name' => 'ExampleName',
                        'number' => 'ExampleNumber',
                    ],
                    'creationtime' => '2016-12-20 13:45:28 UTC',
                    'state' => 'Up',
                    'connected' => [
                        'name' => 'ExampleName2',
                        'number' => 'ExampleNumber2',
                    ],
                    'dialplan' => [
                        'context' => 'ExampleContext',
                        'exten' => 'ExampleExten',
                        'priority' => '3',
                    ],
                    'id' => '123456',
                ],
                'local_port' => 9866
            ]
        );

        $this->assertSame(9866, $externalMedia->getLocalPort());
        $this->assertSame('127.0.0.1', $externalMedia->getLocalAddress());
        $this->assertInstanceOf(Channel::class, $externalMedia->getChannel());
    }
}
