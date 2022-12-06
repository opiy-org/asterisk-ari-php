<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\DialplanCEP;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class DialplanCEPTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class DialplanCEPTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var DialplanCEP $dialplanCEP
         */
        $dialplanCEP = Helper::mapOntoInstance(
            [
                'priority' => 3,
                'exten' => 'ExampleExten',
                'context' => 'ExampleContext',
                'app_name' => 'AppName',
                'app_data' => 'App Data',
            ],
            new DialplanCEP()
        );
        $this->assertSame('ExampleContext', $dialplanCEP->getContext());
        $this->assertSame('ExampleExten', $dialplanCEP->getExten());
        $this->assertSame(3, $dialplanCEP->getPriority());
        $this->assertSame('AppName', $dialplanCEP->getAppName());
        $this->assertSame('App Data', $dialplanCEP->getAppData());
    }
}
