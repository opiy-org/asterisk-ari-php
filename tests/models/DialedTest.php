<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{Dialed};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class DialedTest
 *
 * @package AriStasisApp\Tests\models
 */
final class DialedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Dialed $dialed
         */
        $dialed = mapAriResponseParametersToAriObject(
            'Dialed',
            [
            ]
        );
        $this->assertInstanceOf(Dialed::class, $dialed);
    }
}