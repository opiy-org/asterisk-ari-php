<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\StoredRecording;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class StoredRecordingTest
 *
 * @package NgVoice\AriClient\Tests\Model
 */
final class StoredRecordingTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var StoredRecording $storedRecording
         */
        $storedRecording = mapAriResponseParametersToAriObject(
            'StoredRecording',
            [
                'format' => 'ExampleFormat',
                'name' => 'ExampleName'
            ]
        );
        $this->assertSame('ExampleFormat', $storedRecording->getFormat());
        $this->assertSame('ExampleName', $storedRecording->getName());
    }
}