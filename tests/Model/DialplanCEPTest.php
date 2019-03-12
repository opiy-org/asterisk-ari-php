<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{DialplanCEP};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class DialplanCEPTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class DialplanCEPTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DialplanCEP $dialplanCEP
         */
        $dialplanCEP = mapAriResponseParametersToAriObject(
            'DialplanCEP',
            [
                'priority' => '3',
                'exten' => 'ExampleExten',
                'context' => 'ExampleContext'
            ]
        );
        $this->assertSame('ExampleContext', $dialplanCEP->getContext());
        $this->assertSame('ExampleExten', $dialplanCEP->getExten());
        $this->assertSame('3', $dialplanCEP->getPriority());
    }
}