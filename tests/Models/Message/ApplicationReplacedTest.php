<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models\Message;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{Message\ApplicationReplaced};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationReplacedTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class ApplicationReplacedTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ApplicationReplaced $dialed
         */
        $dialed = Helper::mapMessageParametersToAriObject(
            'ApplicationReplaced',
            [
            ]
        );
        $this->assertInstanceOf(ApplicationReplaced::class, $dialed);
    }
}
