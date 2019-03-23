<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\messages;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{Message\ApplicationReplaced};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapMessageParametersToAriObject;


/**
 * Class ApplicationReplacedTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $dialed = mapMessageParametersToAriObject(
            'ApplicationReplaced',
            [
            ]
        );
        $this->assertInstanceOf(ApplicationReplaced::class, $dialed);
    }
}