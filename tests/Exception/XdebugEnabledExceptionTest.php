<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Exception;

use OpiyOrg\AriClient\Exception\XdebugEnabledException;
use PHPUnit\Framework\TestCase;

/**
 * @package OpiyOrg\AriClient\Exception
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
