<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace NgVoice\AriClient\Tests\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use NgVoice\AriClient\Model\Mailbox;
use NgVoice\AriClient\RestClient\Mailboxes;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class MailboxesTest
 * @package NgVoice\AriClient\Tests\RestClient
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
                    'old_messages' => '5',
                    'new_messages' => '2'
                ]
            ]
        ];
    }

    /**
     * @dataProvider mailboxInstanceProvider
     * @param array $exampleMailbox
     * @throws GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ReflectionException
     */
    public function testGet(array $exampleMailbox): void
    {
        $mailboxesClient = $this->createMailboxesClient($exampleMailbox);
        $resultSound = $mailboxesClient->get('12345');

        $this->assertInstanceOf(Mailbox::class, $resultSound);
    }

    /**
     * @throws GuzzleException
     * @throws ReflectionException
     */
    public function testUpdate(): void
    {
        $mailboxesClient = $this->createMailboxesClient([]);
        $mailboxesClient->update('SomeMailbox', '3', '2');
        $this->assertTrue(true, true);
    }

    /**
     * @throws GuzzleException
     * @throws ReflectionException
     */
    public function testDelete(): void
    {
        $mailboxesClient = $this->createMailboxesClient([]);
        $mailboxesClient->delete('SomeMailbox');
        $this->assertTrue(true, true);
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
            ->willReturn(new Response(
                    200, [], json_encode($expectedResponse), '1.1', 'SomeReason')
            );

        /**
         * @var Client $guzzleClientStub
         */
        return new Mailboxes('SomeUser', 'SomePw', [], $guzzleClientStub);
    }
}
