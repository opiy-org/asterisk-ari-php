<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\Mailbox;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MailboxTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
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
