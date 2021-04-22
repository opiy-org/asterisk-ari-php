<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Exception;

use GuzzleHttp\Exception\ServerException;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use PHPUnit\Framework\TestCase;

/**
 * @package OpiyOrg\AriClient\Exception
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class AsteriskRestInterfaceExceptionTest extends TestCase
{
    public function testGetGuzzleException(): void
    {
        /**
         * @var ServerException $mockedGuzzleObject
         *
         */
        $mockedGuzzleObject = $this->createMock(ServerException::class);

        $guzzleExceptionTest =
            new AsteriskRestInterfaceException($mockedGuzzleObject);
        $this->assertInstanceOf(
            ServerException::class,
            $guzzleExceptionTest->getException()
        );
    }
}
