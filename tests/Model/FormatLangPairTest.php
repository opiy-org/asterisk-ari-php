<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\FormatLangPair;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class FormatLangPairTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $formatLangPair = mapAriResponseParametersToAriObject(
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