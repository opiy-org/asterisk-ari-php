<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\{CallerID};
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class CallerIDTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class CallerIDTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var CallerID $callerId
         */
        $callerId = Helper::mapOntoInstance(
            [
                'name'   => 'ExampleName',
                'number' => 'ExampleNumber',
            ],
            new CallerID()
        );
        $this->assertSame('ExampleName', $callerId->getName());
        $this->assertSame('ExampleNumber', $callerId->getNumber());
    }
}
