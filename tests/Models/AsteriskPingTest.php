<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace AriStasisApp\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{AsteriskPing};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class AsteriskPingTest
 *
 * @package AriStasisApp\Tests\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AsteriskPingTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var AsteriskPing $asteriskPing
         */
        $asteriskPing = Helper::mapAriResponseParametersToAriObject(
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
