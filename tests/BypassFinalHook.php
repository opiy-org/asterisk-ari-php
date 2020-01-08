<?php

/** @copyright 2020 ng-voice GmbH */

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
    /**
     * Remove the final keyword from a class before executing the test.
     *
     * @param string $test The test to remove the final hook from.
     *
     * @return void
     */
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
