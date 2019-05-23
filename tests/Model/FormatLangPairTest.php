<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\FormatLangPair;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatLangPairTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class FormatLangPairTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var FormatLangPair $formatLangPair
         */
        $formatLangPair = Helper::mapAriResponseParametersToAriObject(
            'FormatLangPair',
            [
                'language' => 'en',
                'format' => 'ExampleFormat'
            ]
        );
        $this->assertSame('en', $formatLangPair->getLanguage());
        $this->assertSame('ExampleFormat', $formatLangPair->getFormat());
    }
}
