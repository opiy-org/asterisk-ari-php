<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 20.02.19
 * Time: 11:49
 */

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\TextMessageVariable;
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

class TextMessageVariableTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var TextMessageVariable $textMessageVariable
         */
        $textMessageVariable = mapAriResponseParametersToAriObject(
            'TextMessageVariable',
            [
                'key' => 'SomeKey',
                'value' => 'SomeValue'
            ]
        );
        $this->assertSame('SomeKey', $textMessageVariable->getKey());
        $this->assertSame('SomeValue', $textMessageVariable->getValue());
    }
}
