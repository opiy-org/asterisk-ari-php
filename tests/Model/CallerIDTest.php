<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\{CallerID};
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class CallerIDTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $callerId = mapAriResponseParametersToAriObject(
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