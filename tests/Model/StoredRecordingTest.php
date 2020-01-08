<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\StoredRecording;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class StoredRecordingTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class StoredRecordingTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var StoredRecording $storedRecording
         */
        $storedRecording = Helper::mapOntoInstance(
            [
                'format' => 'ExampleFormat',
                'name'   => 'ExampleName',
            ],
            new StoredRecording()
        );
        $this->assertSame('ExampleFormat', $storedRecording->getFormat());
        $this->assertSame('ExampleName', $storedRecording->getName());
    }
}
