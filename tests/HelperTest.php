<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests;

use Monolog\Logger;
use NgVoice\AriClient\Helper;
use NgVoice\AriClient\Models\Application;
use PHPUnit\Framework\TestCase;

/**
 * Class helperTest
 *
 * @package NgVoice\AriClient\Tests
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class HelperTest extends TestCase
{
    public function testGlueArrayOfStrings(): void
    {
        $this->assertEquals(
            'test,123,peter',
            Helper::glueArrayOfStrings(['test', '123', 'peter'])
        );
    }

    public function testGetShortClassName(): void
    {
        $this->assertEquals('Application', Helper::getShortClassName(new Application()));
    }

    public function testInitLogger(): void
    {
        $this->assertSame(Logger::class, get_class(Helper::initLogger('TestClass')));
    }
}
