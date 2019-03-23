<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Endpoint, Message\TextMessageReceived, TextMessage};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;

/**
 * Class TextMessageReceivedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
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
        $textMessageReceived = mapMessageParametersToAriObject(
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