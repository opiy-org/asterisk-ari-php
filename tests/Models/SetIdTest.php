<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;

use JsonMapper_Exception;
use NgVoice\AriClient\Models\SetId;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SetIdTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class SetIdTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var SetId $setId
         */
        $setId = Helper::mapAriResponseParametersToAriObject(
            'SetId',
            [
                'user' => 'ExampleUser',
                'group' => 'ExampleGroup'
            ]
        );
        $this->assertSame('ExampleUser', $setId->getUser());
        $this->assertSame('ExampleGroup', $setId->getGroup());
    }
}
