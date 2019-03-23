<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests;


use Monolog\Logger;
use NgVoice\AriClient\Model\Application;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\{getAsteriskDefaultSettings,
    getShortClassName,
    glueArrayOfStrings,
    initLogger,
    parseAriSettings,
    parseMyApiSettings,
    parseWebSocketSettings};

/**
 * Class helping_functionsTest
 *
 * @package NgVoice\AriClient\Tests
 */
final class helping_functionsTest extends TestCase
{
    public function testGlueArrayOfStrings(): void
    {
        $this->assertEquals('test,123,peter', glueArrayOfStrings(['test', '123', 'peter']));
    }

    public function testGetAsteriskDefaultSettings(): void
    {
        $this->assertIsArray(getAsteriskDefaultSettings());
    }

    public function testParseMyApiSettings(): void
    {
        $this->assertEquals('jo', parseMyApiSettings(['test' => 'jo'])['test']);
    }

    public function testParseAriSettings(): void
    {
        $this->assertEquals('jo', parseAriSettings(['test' => 'jo'])['test']);
    }

    public function testParseWebSocketSettings(): void
    {
        $this->assertEquals('jo', parseWebSocketSettings(['test' => 'jo'])['test']);
    }

    public function testGetShortClassName(): void
    {
        $this->assertEquals('Application', getShortClassName(new Application()));
    }

    public function testInitLogger(): void
    {
        $this->assertSame(Logger::class, get_class(initLogger('TestClass')));
    }
}