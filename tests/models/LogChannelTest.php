<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{LogChannel};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class LogChannelTest
 *
 * @package AriStasisApp\Tests\models
 */
final class LogChannelTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var LogChannel $logChannel
         */
        $logChannel = mapAriResponseParametersToAriObject(
            'LogChannel',
            [
                'configuration' => '3',
                'type' => 'DEBUG,ERROR',
                'status' => 'enabled',
                'channel' => '/var/log/syslog'
            ]
        );
        $this->assertSame('enabled', $logChannel->getStatus());
        $this->assertSame('/var/log/syslog', $logChannel->getChannel());
        $this->assertSame('3', $logChannel->getConfiguration());
        $this->assertSame('DEBUG,ERROR', $logChannel->getType());
    }
}