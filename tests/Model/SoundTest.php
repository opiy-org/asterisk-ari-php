<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\Sound;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SoundTest
 *
 * @package AriStasisApp\Tests\Models
 */
final class SoundTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Sound $sound
         */
        $sound = Helper::mapAriResponseParametersToAriObject(
            'Sound',
            [
                'id' => 'ExampleId',
                'formats' => [
                    [
                        'format' => 'X',
                        'language' => 'Y'
                    ]
                ],
                'text' => 'ExampleText'
            ]
        );
        $this->assertSame('ExampleId', $sound->getId());
        $this->assertCount(1, $sound->getFormats());
        $this->assertSame('X', $sound->getFormats()[0]->getFormat());
        $this->assertSame('ExampleText', $sound->getText());
    }
}
