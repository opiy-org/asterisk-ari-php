<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\SystemInfo;
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class SystemInfoTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class SystemInfoTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var SystemInfo $systemInfo
         */
        $systemInfo = mapAriResponseParametersToAriObject(
            'SystemInfo',
            [
                'version' => '16.1.0',
                'entity_id' => '02:42:ac:11:00:01'
            ]
        );
        $this->assertInstanceOf(SystemInfo::class, $systemInfo);
        $this->assertSame('02:42:ac:11:00:01', $systemInfo->getEntityId());
        $this->assertSame('16.1.0', $systemInfo->getVersion());
    }
}