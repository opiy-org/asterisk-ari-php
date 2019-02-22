<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests;


require_once __DIR__ . '/shared_test_functions.php';
require_once __DIR__ . '/../src/helping_functions.php';

use AriStasisApp\models\Application;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use function AriStasisApp\getAsteriskDefaultSettings;
use function AriStasisApp\getShortClassName;
use function AriStasisApp\glueArrayOfStrings;
use function AriStasisApp\initLogger;
use function AriStasisApp\parseAriSettings;
use function AriStasisApp\parseMyApiSettings;
use function AriStasisApp\parseWebSocketSettings;

/**
 * Class helping_functionsTest
 *
 * @package AriStasisApp\Tests
 */
final class helping_functionsTest extends TestCase
{
    public function testGlueArrayOfStrings()
    {
        $this->assertEquals('test,123,peter', glueArrayOfStrings(['test', '123', 'peter']));
    }

    public function testGetAsteriskDefaultSettings()
    {
        $this->assertIsArray(getAsteriskDefaultSettings());
    }

    public function testParseMyApiSettings()
    {
        $this->assertEquals('jo', parseMyApiSettings(['test' => 'jo'])['test']);
    }

    public function testParseAriSettings()
    {
        $this->assertEquals('jo', parseAriSettings(['test' => 'jo'])['test']);
    }

    public function testParseWebSocketSettings()
    {
        $this->assertEquals('jo', parseWebSocketSettings(['test' => 'jo'])['test']);
    }

    public function testGetShortClassName()
    {
        $this->assertEquals('Application', getShortClassName(new Application()));
    }

    public function testInitLogger()
    {
        $this->assertInstanceOf(Logger::class, initLogger('TestClass'));
    }
}