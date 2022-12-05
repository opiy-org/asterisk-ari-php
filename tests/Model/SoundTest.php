<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\Sound;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SoundTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class SoundTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Sound $sound
         */
        $sound = Helper::mapOntoInstance(
            [
                'id'      => 'ExampleId',
                'formats' => [
                    [
                        'format'   => 'X',
                        'language' => 'Y',
                    ],
                ],
                'text'    => 'ExampleText',
            ],
            new Sound()
        );
        $this->assertSame('ExampleId', $sound->getId());
        $this->assertCount(1, $sound->getFormats());
        $this->assertSame('X', $sound->getFormats()[0]->getFormat());
        $this->assertSame('ExampleText', $sound->getText());
    }
}
