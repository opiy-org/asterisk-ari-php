<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Endpoint;
use OpiyOrg\AriClient\Model\Message\Event\TextMessageReceived;
use OpiyOrg\AriClient\Model\TextMessage;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\EndpointTest;
use PHPUnit\Framework\TestCase;

/**
 * Class TextMessageReceivedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class TextMessageReceivedTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var TextMessageReceived $textMessageReceived
         */
        $textMessageReceived = Helper::mapOntoAriEvent(
            TextMessageReceived::class,
            [
                'endpoint' => EndpointTest::RAW_ARRAY_REPRESENTATION,
                'message' => [
                    'body' => 'ExampleBody',
                    'from' => 'pjsip/bla1',
                    'to' => 'pjsip/bla',
                    'variables' => [
                        [
                            'key' => 'X',
                            'value' => 'Y',
                        ],
                    ],
                ],
            ]
        );
        $this->assertInstanceOf(Endpoint::class, $textMessageReceived->getEndpoint());
        $this->assertInstanceOf(TextMessage::class, $textMessageReceived->getMessage());
    }
}
