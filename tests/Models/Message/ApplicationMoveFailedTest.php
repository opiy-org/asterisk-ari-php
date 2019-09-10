<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Channel, Message\ApplicationMoveFailed};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationMoveFailedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class ApplicationMoveFailedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ApplicationMoveFailed $applicationMoveFailed
         */
        $exampleChannel = [
            'name' => 'SIP/foo-0000a7e3',
            'language' => 'en',
            'accountcode' => 'TestAccount',
            'channelvars' => [
                'testVar' => 'correct',
                'testVar2' => 'nope'
            ],
            'caller' => [
                'name' => 'ExampleName',
                'number' => 'ExampleNumber'
            ],
            'creationtime' => '2016-12-20 13:45:28 UTC',
            'state' => 'Up',
            'connected' => [
                'name' => 'ExampleName2',
                'number' => 'ExampleNumber2'
            ],
            'dialplan' => [
                'context' => 'ExampleContext',
                'exten' => 'ExampleExten',
                'priority' => '3'
            ],
            'id' => '123456'
        ];
        $applicationMoveFailed = Helper::mapMessageParametersToAriObject(
            'ApplicationMoveFailed',
            [
                'args' => ['Key1' => '1',
                    'Key2' => '2',
                    'Key3' => '3'],
                'destination' => 'Destination',
                'channel' => $exampleChannel
            ]
        );
        $this->assertSame(
            ['Key1' => '1', 'Key2' => '2',
                'Key3' => '3'],
            $applicationMoveFailed->getArgs()
        );
        $this->assertInstanceOf(
            Channel::class,
            $applicationMoveFailed->getChannel()
        );
        $this->assertSame('Destination', $applicationMoveFailed->getDestination());
    }
}
