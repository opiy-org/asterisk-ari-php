<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Message\MissingParams};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MissingParamsTest
 *
 * @package NgVoice\AriClient\Tests\Models\Message
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
        $missingParams = Helper::mapMissingParams();
        $this->assertSame(['ExampleParam', 'ExampleParam2'], $missingParams->getParams());
    }
}
