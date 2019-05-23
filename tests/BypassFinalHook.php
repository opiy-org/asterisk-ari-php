<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

/**
 * Final classes cannot be mocked in phpunit, so this class removes the
 * final class tag on-the-fly in order to be able to test those classes.
 *
 * @see https://www.tomasvotruba.cz/blog/2019/03/28/how-to-mock-final-classes-in-phpunit/
 *
 * @package NgVoice\AriClient\Tests
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class BypassFinalHook implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
