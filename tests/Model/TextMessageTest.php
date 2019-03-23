<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\TextMessage;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class TextMessageTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $textMessage = mapAriResponseParametersToAriObject(
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