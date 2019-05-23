<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\DialplanCEP;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class DialplanCEPTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class DialplanCEPTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DialplanCEP $dialplanCEP
         */
        $dialplanCEP = Helper::mapAriResponseParametersToAriObject(
            'DialplanCEP',
            [
                'priority' => '3',
                'exten' => 'ExampleExten',
                'context' => 'ExampleContext'
            ]
        );
        $this->assertSame('ExampleContext', $dialplanCEP->getContext());
        $this->assertSame('ExampleExten', $dialplanCEP->getExten());
        $this->assertSame('3', $dialplanCEP->getPriority());
    }
}
