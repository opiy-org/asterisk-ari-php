<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\models\{Channel, messages\ChannelHangupRequest};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class ChannelHangupRequestTest
 *
 * @package AriStasisApp\Tests\models\messages
 */
final class ChannelHangupRequestTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
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

        /**
         * @var ChannelHangupRequest $channelHangupRequest
         */
        $channelHangupRequest = mapMessageParametersToAriObject(
            'ChannelHangupRequest',
            [
                'soft' => true,
                'cause' => 45,
                'channel' => $exampleChannel
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelHangupRequest->getChannel());
        $this->assertSame(45, $channelHangupRequest->getCause());
        $this->assertTrue($channelHangupRequest->isSoft());
    }
}