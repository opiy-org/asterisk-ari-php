<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection The [EA] plugin for PhpStorm doesn't know
 * about the noinspection annotation.
 * @noinspection ClassMockingCorrectnessInspection We are using a dependency to hook
 * onto classes before the tests in order to remove the 'final' class keyword. This makes
 * the classes extendable for PhpUnit and therefore testable.
 */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;
use OpiyOrg\AriClient\Model\Message\Event\ApplicationMoveFailed;
use OpiyOrg\AriClient\Tests\Helper;
use OpiyOrg\AriClient\Tests\Model\ChannelTest;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationMoveFailedTest
 *
 * @package OpiyOrg\AriClient\Tests\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ApplicationMoveFailedTest extends TestCase
{
    public function testGetter(): void
    {
        /** @var ApplicationMoveFailed $applicationMoveFailed */
        $applicationMoveFailed = Helper::mapOntoAriEvent(
            ApplicationMoveFailed::class,
            [
                'args' => ['one', 'two', 'three'],
                'destination' => 'someDestination',
                'channel' => ChannelTest::RAW_ARRAY_REPRESENTATION,
            ]
        );

        $this->assertSame(
            'someDestination',
            $applicationMoveFailed->getDestination()
        );
        $this->assertInstanceOf(
            Channel::class,
            $applicationMoveFailed->getChannel()
        );
        $this->assertSame(
            ['one', 'two', 'three'],
            $applicationMoveFailed->getArgs()
        );
    }
}
