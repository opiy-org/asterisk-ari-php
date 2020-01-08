<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\FormatLangPair;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatLangPairTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class FormatLangPairTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var FormatLangPair $formatLangPair
         */
        $formatLangPair = Helper::mapOntoInstance(
            [
                'language' => 'en',
                'format'   => 'ExampleFormat',
            ],
            new FormatLangPair()
        );
        $this->assertSame('en', $formatLangPair->getLanguage());
        $this->assertSame('ExampleFormat', $formatLangPair->getFormat());
    }
}
