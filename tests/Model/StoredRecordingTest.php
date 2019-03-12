<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{StoredRecording};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class StoredRecordingTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class StoredRecordingTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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