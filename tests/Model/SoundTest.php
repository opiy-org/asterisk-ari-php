<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\Sound;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class SoundTest
 *
 * @package AriStasisApp\Tests\Model
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
        $sound = mapAriResponseParametersToAriObject(
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