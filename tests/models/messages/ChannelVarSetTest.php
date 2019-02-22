<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\models\{Channel, messages\ChannelVarSet};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class ChannelVarSetTest
 *
 * @package AriStasisApp\Tests\models\messages
 */
final class ChannelVarSetTest extends TestCase
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
         * @var ChannelVarSet $channelVarSet
         */
        $channelVarSet = mapMessageParametersToAriObject(
            'ChannelVarSet',
            [
                'variable' => 'TestVar',
                'value' => 'TestValue',
                'channel' => $exampleChannel
            ]
        );
        $this->assertInstanceOf(Channel::class, $channelVarSet->getChannel());
        $this->assertSame('TestVar', $channelVarSet->getVariable());
        $this->assertSame('TestValue', $channelVarSet->getValue());
    }
}