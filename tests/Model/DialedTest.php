<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\Dialed;
use PHPUnit\Framework\TestCase;

/**
 * Class DialedTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DialedTest extends TestCase
{
    /**
     */
    public function testParametersMappedCorrectly(): void
    {
        $this->assertInstanceOf(Dialed::class, new Dialed());
    }
}
