<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client;

use InvalidArgumentException;
use Monolog\Logger;
use OpiyOrg\AriClient\Client\AbstractSettings;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractSettingsTest
 *
 * @package OpiyOrg\AriClient\Tests\Client
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class AbstractSettingsTest extends TestCase
{
    private AbstractSettings $abstractSettings;

    public function setUp(): void
    {
        $this->abstractSettings =
            new class ('asterisk', 'asterisk') extends AbstractSettings {};
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(AbstractSettings::class, $this->abstractSettings);
    }

    public function testGetPassword(): void
    {
        $this->assertSame('asterisk', $this->abstractSettings->getPassword());
    }

    public function testRootUri(): void
    {
        $this->abstractSettings->setRootUri('/someRootUri');
        $this->assertSame('/someRootUri', $this->abstractSettings->getRootUri());
    }

    public function testWrongRootUriThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->abstractSettings->setRootUri('/someRootUri/');
    }

    public function testHost(): void
    {
        $this->abstractSettings->setHost('some.host');
        $this->assertSame('some.host', $this->abstractSettings->getHost());
    }

    public function testPort(): void
    {
        $this->abstractSettings->setPort(111);
        $this->assertSame(111, $this->abstractSettings->getPort());
    }

    public function testPortDoesntAcceptInvalidPortNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->abstractSettings->setPort(-12);
    }

    public function testUser(): void
    {
        $this->assertSame('asterisk', $this->abstractSettings->getUser());
    }

    public function testLogger(): void
    {
        $loggerInterface = $this->createMock(Logger::class);
        $this->abstractSettings->setLoggerInterface($loggerInterface);

        $this->assertSame($loggerInterface, $this->abstractSettings->getLoggerInterface());
    }
}
