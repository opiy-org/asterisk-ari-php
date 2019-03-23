<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\Mailbox;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class MailboxTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $mailbox = mapAriResponseParametersToAriObject(
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