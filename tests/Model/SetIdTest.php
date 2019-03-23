<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Model;


use JsonMapper_Exception;
use NgVoice\AriClient\Model\SetId;
use PHPUnit\Framework\TestCase;
use function NgVoice\AriClient\Tests\mapAriResponseParametersToAriObject;

/**
 * Class SetIdTest
 *
 * @package NgVoice\AriClient\Tests\Model
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
        $setId = mapAriResponseParametersToAriObject(
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