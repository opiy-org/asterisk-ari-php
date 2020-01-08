<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message\Event;

use NgVoice\AriClient\Model\Message\Event\ApplicationReplaced;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationReplacedTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ApplicationReplacedTest extends TestCase
{
    public function testCreate(): void
    {
        $this->assertInstanceOf(ApplicationReplaced::class, new ApplicationReplaced());
    }
}
