<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{Endpoint, Message\TextMessageReceived, TextMessage};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class TextMessageReceivedTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class TextMessageReceivedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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