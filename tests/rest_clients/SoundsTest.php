<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\models\Sound;
use AriStasisApp\rest_clients\Sounds;
use PHPUnit\Framework\TestCase;

/**
 * Class SoundsTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class SoundsTest extends TestCase
{
    public function asteriskInstanceProvider()
    {
        return [
            'setup sounds' => [new Sounds('asterisk', 'asterisk')]
        ];
    }

    /**
     * @dataProvider asteriskInstanceProvider
     * @param Sounds $soundsClient
     *
     * @expectedException \GuzzleHttp\Exception\GuzzleException
     * @expectedExceptionCode 404
     */
    public function testWrongSoundIdThrowsException(Sounds $soundsClient): void
    {
        $soundsClient->get('xyz');
    }

    /**
     * @dataProvider asteriskInstanceProvider
     * @param Sounds $soundsClient
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreateSoundInstance(Sounds $soundsClient): void
    {
        $this->assertInstanceOf(Sound::class, $soundsClient->get('confbridge-only-participant'));
    }
}