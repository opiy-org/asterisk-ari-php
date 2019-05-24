<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use NgVoice\AriClient\Models\Dialed;
use PHPUnit\Framework\TestCase;

/**
 * Class DialedTest
 *
 * @package NgVoice\AriClient\Tests\Models
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
