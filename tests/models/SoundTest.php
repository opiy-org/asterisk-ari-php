<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{Sound};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class SoundTest
 *
 * @package AriStasisApp\Tests\models
 */
final class SoundTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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
        $this->assertSame(1, sizeof($sound->getFormats()));
        $this->assertSame('X', $sound->getFormats()[0]->getFormat());
        $this->assertSame('ExampleText', $sound->getText());
    }
}