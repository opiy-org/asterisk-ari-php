<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\FormatLangPair;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatLangPairTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
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
                'format' => 'ExampleFormat',
            ],
            new FormatLangPair()
        );
        $this->assertSame('en', $formatLangPair->getLanguage());
        $this->assertSame('ExampleFormat', $formatLangPair->getFormat());
    }
}
