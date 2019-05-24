<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\TextMessage;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class TextMessageTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class TextMessageTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var TextMessage $textMessage
         */
        $textMessage = Helper::mapAriResponseParametersToAriObject(
            'TextMessage',
            [
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
        );
        $this->assertSame('ExampleBody', $textMessage->getBody());
        $this->assertSame('pjsip/bla1', $textMessage->getFrom());
        $this->assertSame('pjsip/bla', $textMessage->getTo());
        $this->assertCount(1, $textMessage->getVariables());
        $this->assertSame('Y', $textMessage->getVariables()[0]->getValue());
    }
}
