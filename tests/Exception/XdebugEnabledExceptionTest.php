<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Exception;

use NgVoice\AriClient\Exception\XdebugEnabledException;
use PHPUnit\Framework\TestCase;

/**
 * @package NgVoice\AriClient\Exception
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class XdebugEnabledExceptionTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->expectException(XdebugEnabledException::class);
        throw new XdebugEnabledException('someExceptionMessage');
    }
}
