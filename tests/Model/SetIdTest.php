<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;

use NgVoice\AriClient\Model\SetId;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SetIdTest
 *
 * @package NgVoice\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class SetIdTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var SetId $setId
         */
        $setId = Helper::mapOntoInstance(
            [
                'user'  => 'ExampleUser',
                'group' => 'ExampleGroup',
            ],
            new SetId()
        );
        $this->assertSame('ExampleUser', $setId->getUser());
        $this->assertSame('ExampleGroup', $setId->getGroup());
    }
}
