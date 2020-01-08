<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\Mailbox;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MailboxTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class MailboxTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Mailbox $mailbox
         */
        $mailbox = Helper::mapOntoInstance(
            [
                'name'         => 'ExampleName',
                'old_messages' => 5,
                'new_messages' => 2,
            ],
            new Mailbox()
        );
        $this->assertSame('ExampleName', $mailbox->getName());
        $this->assertSame(2, $mailbox->getNewMessages());
        $this->assertSame(5, $mailbox->getOldMessages());
    }
}
