<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\SetId;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class SetIdTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
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
                'user' => 'ExampleUser',
                'group' => 'ExampleGroup',
            ],
            new SetId()
        );
        $this->assertSame('ExampleUser', $setId->getUser());
        $this->assertSame('ExampleGroup', $setId->getGroup());
    }
}
