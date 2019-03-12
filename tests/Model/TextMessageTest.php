<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{TextMessage};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class TextMessageTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class TextMessageTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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
        $this->assertSame(1, sizeof($textMessage->getVariables()));
        $this->assertSame('Y', $textMessage->getVariables()[0]->getValue());
    }
}