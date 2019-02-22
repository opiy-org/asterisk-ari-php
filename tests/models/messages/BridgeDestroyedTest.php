<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\models\{Bridge, messages\BridgeDestroyed};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

/**
 * Class BridgeDestroyedTest
 *
 * @package AriStasisApp\Tests\models\messages
 */
final class BridgeDestroyedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var BridgeDestroyed $bridgeDestroyed
         */
        $bridgeDestroyed = mapMessageParametersToAriObject(
            'BridgeDestroyed',
            [
                'bridge' => [
                    'bridge_class' => 'ExampleClass',
                    'bridge_type' => 'mixing',
                    'channels' => [],
                    'creator' => 'ExampleCreator',
                    'id' => 'id1',
                    'name' => 'ExampleName',
                    'technology' => 'ExampleTechnology',
                    'video_mode' => 'none',
                    'video_source_id' => 'VideoId'
                ]
            ]
        );
        $this->assertInstanceOf(Bridge::class, $bridgeDestroyed->getBridge());
    }
}