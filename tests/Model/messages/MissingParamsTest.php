<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Message\MissingParams};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMissingParams;

/**
 * Class MissingParamsTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 */
final class MissingParamsTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var MissingParams $missingParams
         */
        $missingParams = mapMissingParams();
        $this->assertSame(['ExampleParam', 'ExampleParam2'], $missingParams->getParams());
    }
}