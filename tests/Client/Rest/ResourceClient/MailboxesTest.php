<?php

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Client\Rest\ResourceClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use OpiyOrg\AriClient\Client\Rest\Resource\Mailboxes;
use OpiyOrg\AriClient\Client\Rest\Settings;
use OpiyOrg\AriClient\Exception\AsteriskRestInterfaceException;
use OpiyOrg\AriClient\Model\Mailbox;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class MailboxesTest
 *
 * @package OpiyOrg\AriClient\Tests\Rest
 */
class MailboxesTest extends TestCase
{
    /**
     * @return array
     */
    public function mailboxInstanceProvider(): array
    {
        return [
            'example mailbox' => [
                [
                    'name' => 'ExampleName',
                    'old_messages' => 5,
                    'new_messages' => 2,
                ],
            ],
        ];
    }

    /**
     * @dataProvider mailboxInstanceProvider
     * @param array $exampleMailbox
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testList(array $exampleMailbox): void
    {
        $soundsClient = $this->createMailboxesClient(
            [$exampleMailbox, $exampleMailbox, $exampleMailbox]
        );
        $resultList = $soundsClient->list();

        $this->assertIsArray($resultList);
        foreach ($resultList as $resultSound) {
            $this->assertInstanceOf(Mailbox::class, $resultSound);
        }
    }

    /**
     * @dataProvider mailboxInstanceProvider
     * @param string[] $exampleMailbox
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testGet(array $exampleMailbox): void
    {
        $mailboxesClient = $this->createMailboxesClient($exampleMailbox);
        $resultSound = $mailboxesClient->get('12345');

        $this->assertInstanceOf(Mailbox::class, $resultSound);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testUpdate(): void
    {
        $mailboxesClient = $this->createMailboxesClient([]);
        $mailboxesClient->update('SomeMailbox', 3, 2);
        $this->assertTrue(true);
    }

    /**
     * @throws AsteriskRestInterfaceException
     * @throws ReflectionException
     */
    public function testDelete(): void
    {
        $mailboxesClient = $this->createMailboxesClient([]);
        $mailboxesClient->delete('SomeMailbox');
        $this->assertTrue(true);
    }

    /**
     * @param $expectedResponse
     * @return Mailboxes
     * @throws ReflectionException
     */
    private function createMailboxesClient($expectedResponse): Mailboxes
    {
        $guzzleClientStub = $this->createMock(Client::class);
        $guzzleClientStub->method('request')
            // TODO: Test for correct parameter translation via with() method here?
            //  ->with()
            ->willReturn(
                new Response(
                    200,
                    [],
                    json_encode($expectedResponse),
                    '1.1',
                    'SomeReason'
                )
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Mailboxes(
            new Settings('SomeUser', 'SomePw'),
            $guzzleClientStub
        );
    }
}
