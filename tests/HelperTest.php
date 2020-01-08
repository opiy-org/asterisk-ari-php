<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

/**
 * Overriding built-in PHP Class when testing in order to mock them.
 */

namespace NgVoice\AriClient {
    /**
     * @return bool
     */
    function trigger_error($error_msg, $error_type = E_USER_NOTICE): bool
    {
        return true;
    }

    /**
     * Dummy class
     *
     * @package NgVoice\AriClient
     *
     * @author Lukas Stermann <lukas@ng-voice.com>
     */
    class Yaml
    {
        /**
         * @return array
         */
        public static function parseFile(): array
        {
            return ['debug_mode' => false];
        }
    }
}
namespace NgVoice\AriClient\Tests {

    use Exception;
    use Monolog\Logger;
    use NgVoice\AriClient\Helper;
    use NgVoice\AriClient\Model\Application;
    use PHPUnit\Framework\TestCase;
    use ReflectionObject;

    /**
     * Class helperTest
     *
     * @package NgVoice\AriClient\Tests
     *
     * @author Lukas Stermann <lukas@ng-voice.com>
     * @author Ahmad Hussain <ahmad@ng-voice.com>
     */
    final class HelperTest extends TestCase
    {
        public function testGetShortClassName(): void
        {
            $shortClassName = (new ReflectionObject(new Application()))->getShortName();

            $this->assertEquals('Application', $shortClassName);
        }

        public function testInitLogger(): void
        {
            $this->assertInstanceOf(Logger::class, Helper::initLogger('TestClass'));

            $this->assertInstanceOf(
                Logger::class,
                Helper::initLogger(
                    'TestClass',
                    $this->createMock(Logger::class)
                )
            );
        }

        public function testInitLoggerHandlesException(): void
        {
            $logger = $this->createMock(Logger::class);
            $logger->method('pushHandler')->willThrowException(new Exception());

            Helper::initLogger('SomeName', $logger);

            $this->assertTrue(true);
        }
    }
}
