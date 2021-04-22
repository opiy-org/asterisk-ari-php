<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\ConfigInfo;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigInfoTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ConfigInfoTest extends TestCase
{
    public const RAW_ARRAY_REPRESENTATION = [
        'name'             => 'SomeName',
        'default_language' => 'en',
        'setid'            => [
            'user'  => 'SomeUser',
            'group' => 'SomeGroup',
        ],
        'max_channels'     => 3,
        'max_load'         => 13.2,
        'max_open_files'   => 14,
    ];

    public function testParametersMappedCorrectly(): void
    {
        $configInfo = new ConfigInfo();

        Helper::mapOntoInstance(self::RAW_ARRAY_REPRESENTATION, $configInfo);

        $this->assertInstanceOf(ConfigInfo::class, $configInfo);
        $this->assertSame('SomeName', $configInfo->getName());
        $this->assertSame('en', $configInfo->getDefaultLanguage());
        $this->assertSame(3, $configInfo->getMaxChannels());
        $this->assertSame(13.2, $configInfo->getMaxLoad());
        $this->assertSame(14, $configInfo->getMaxOpenFiles());
        $configInfoSetId = $configInfo->getSetid();
        $this->assertSame('SomeUser', $configInfoSetId->getUser());
        $this->assertSame('SomeGroup', $configInfoSetId->getGroup());
    }
}
