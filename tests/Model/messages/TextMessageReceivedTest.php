<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Endpoint, Message\TextMessageReceived, TextMessage};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class TextMessageReceivedTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
 */
final class TextMessageReceivedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        $exampleEndpoint = [
            'state' => 'online',
            'technology' => 'ExampleTechnology',
            'channel_ids' => [
                'firstChannel',
                'secondChannel'
            ],
            'resource' => 'ExampleResource'
        ];

        /**
         * @var TextMessageReceived $textMessageReceived
         */
        $textMessageReceived = Helper::mapMessageParametersToAriObject(
            'TextMessageReceived',
            [
                'endpoint' => $exampleEndpoint,
                'message' => [
                    'body' => 'ExampleBody',
                    'from' => 'pjsip/bla1',
                    'to' => 'pjsip/bla',
                    'variables' => [
                        [
                            'key' => 'X',
                            'value' => 'Y'
                        ]
                    ]
                ]
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $textMessageReceived->getEndpoint());
        $this->assertInstanceOf(TextMessage::class, $textMessageReceived->getMessage());
    }
}
