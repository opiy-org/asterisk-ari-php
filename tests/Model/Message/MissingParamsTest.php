<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model\Message;

use NgVoice\AriClient\Model\Message\MissingParams;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MissingParamsTest
 *
 * @package NgVoice\AriClient\Tests\Model\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class MissingParamsTest extends TestCase
{
    private MissingParams $missingParams;

    public function setUp(): void
    {
        $this->missingParams = new MissingParams();
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(MissingParams::class, $this->missingParams);
    }

    public function testSetAndGetParams(): void
    {
        $params = ['param1', 'param2'];

        Helper::mapOntoInstance(
            ['params' => $params, 'type' => 'MissingParams'],
            $this->missingParams
        );

        $this->assertSame($params, $this->missingParams->getParams());
    }
}
