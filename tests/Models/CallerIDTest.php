<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\{CallerID};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class CallerIDTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class CallerIDTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var CallerID $callerId
         */
        $callerId = Helper::mapAriResponseParametersToAriObject(
            'CallerID',
            [
                'name' => 'ExampleName',
                'number' => 'ExampleNumber'
            ]
        );
        $this->assertSame('ExampleName', $callerId->getName());
        $this->assertSame('ExampleNumber', $callerId->getNumber());
    }
}
