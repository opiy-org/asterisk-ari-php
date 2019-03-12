<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\Model\{ConfigInfo, SetId};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapAriResponseParametersToAriObject;

/**
 * Class ConfigInfoTest
 *
 * @package AriStasisApp\Tests\Model
 */
final class ConfigInfoTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ConfigInfo $configInfo
         */
        $configInfo = mapAriResponseParametersToAriObject(
            'ConfigInfo',
            [
                'name' => 'SomeName',
                'default_language' => 'en',
                'setid' => [
                    'user' => 'SomeUser',
                    'group' => 'SomeGroup'
                ],
                'max_channels' => '3',
                'max_load' => '13.2',
                'max_open_files' => '14'
            ]
        );
        $this->assertInstanceOf(ConfigInfo::class, $configInfo);
        $this->assertSame('SomeName', $configInfo->getName());
        $this->assertSame('en', $configInfo->getDefaultLanguage());
        $this->assertSame(3, $configInfo->getMaxChannels());
        $this->assertSame(13.2, $configInfo->getMaxLoad());
        $this->assertSame(14, $configInfo->getMaxOpenFiles());
        $configInfoSetId = $configInfo->getSetid();
        $this->assertInstanceOf(SetId::class, $configInfoSetId);
        $this->assertSame('SomeUser', $configInfoSetId->getUser());
        $this->assertSame('SomeGroup', $configInfoSetId->getGroup());
    }
}