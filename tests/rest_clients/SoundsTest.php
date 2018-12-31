<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\rest_clients;


use AriStasisApp\models\FormatLangPair;
use AriStasisApp\models\Sound;
use AriStasisApp\rest_clients\Sounds;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SoundsTest
 *
 * @package AriStasisApp\Tests\http_client
 */
final class SoundsTest extends TestCase
{
    public function soundsInstanceProvider()
    {
        $settings = Yaml::parseFile(__DIR__ . '/../../environment.yaml');
        return [
            'setup sounds' =>
                [new Sounds($settings['tests']['asteriskUser'], $settings['tests']['asteriskPassword'])]
        ];
    }

    /**
     * @dataProvider soundsInstanceProvider
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
     * @dataProvider soundsInstanceProvider
     * @param Sounds $soundsClient
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreateSoundInstance(Sounds $soundsClient): void
    {
        $sound = $soundsClient->get('confbridge-only-participant');
        $this->assertInstanceOf(Sound::class, $sound);
        $this->assertInstanceOf(FormatLangPair::class, $sound->getFormats()[0]);
        $this->assertTrue(is_string($sound->getId()));
        $this->assertTrue(is_string($sound->getText()));
    }

    /**
     * @dataProvider soundsInstanceProvider
     * @param Sounds $soundsClient
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListAllSounds(Sounds $soundsClient): void
    {
        $soundsList = $soundsClient->list();
        $this->assertInstanceOf(Sound::class, $soundsList[0]);
        $this->assertInstanceOf(FormatLangPair::class, $soundsList[0]->getFormats()[0]);
    }
}