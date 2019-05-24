<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\{ConfigInfo, SetId};
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigInfoTest
 *
 * @package NgVoice\AriClient\Tests\Models
 */
final class ConfigInfoTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ConfigInfo $configInfo
         */
        $configInfo = Helper::mapAriResponseParametersToAriObject(
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
