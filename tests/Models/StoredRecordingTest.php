<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\StoredRecording;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class StoredRecordingTest
 *
 * @package NgVoice\AriClient\Tests\Models
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
        $storedRecording = Helper::mapAriResponseParametersToAriObject(
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
