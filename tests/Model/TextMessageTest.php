<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\TextMessage;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class TextMessageTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class TextMessageTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var TextMessage $textMessage
         */
        $textMessage = Helper::mapOntoInstance(
            [
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
            new TextMessage()
        );
        $this->assertSame('ExampleBody', $textMessage->getBody());
        $this->assertSame('pjsip/bla1', $textMessage->getFrom());
        $this->assertSame('pjsip/bla', $textMessage->getTo());
        $this->assertCount(1, $textMessage->getVariables());
        $this->assertSame('Y', $textMessage->getVariables()[0]->getValue());
    }
}
