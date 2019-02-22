<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{CallerID};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class CallerIDTest
 *
 * @package AriStasisApp\Tests\models
 */
final class CallerIDTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var CallerID $callerId
         */
        $callerId = mapAriResponseParametersToAriObject(
            'CallerID',
            [
                'name' => 'ExampleName',
                'number' => 'ExampleNumber'
            ]
        );
        $this->assertSame('ExampleName', $callerId->getName());
        $this->assertSame('ExampleNumber', $callerId->getNumber());
    }
}