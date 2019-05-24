<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\Mailbox;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MailboxTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class MailboxTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var Mailbox $mailbox
         */
        $mailbox = Helper::mapAriResponseParametersToAriObject(
            'Mailbox',
            [
                'name' => 'ExampleName',
                'old_messages' => '5',
                'new_messages' => '2'
            ]
        );
        $this->assertSame('ExampleName', $mailbox->getName());
        $this->assertSame(2, $mailbox->getNewMessages());
        $this->assertSame(5, $mailbox->getOldMessages());
    }
}
