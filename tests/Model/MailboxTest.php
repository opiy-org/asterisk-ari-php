<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{Mailbox};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class MailboxTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class MailboxTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
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