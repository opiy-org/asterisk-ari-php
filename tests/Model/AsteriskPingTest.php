<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{AsteriskPing};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class AsteriskPingTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class AsteriskPingTest extends TestCase
{
    /*
     * All of the AsteriskInfo Elements are tested in their own tests.
     * We therefore do not need an extra test for this class.
     */

    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var AsteriskPing $asteriskPing
         */
        $asteriskPing = mapAriResponseParametersToAriObject(
            'AsteriskPing',
            [
                'timestamp' => '2016-12-20 13:45:28 UTC',
                'ping' => 'pong',
                'asterisk_id' => '12334679672'
            ]
        );
        $this->assertSame('12334679672', $asteriskPing->getAsteriskId());
        $this->assertSame('pong', $asteriskPing->getPing());
        $this->assertSame('2016-12-20 13:45:28 UTC', $asteriskPing->getTimestamp());
    }
}