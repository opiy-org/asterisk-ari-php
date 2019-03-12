<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\Model;


require_once __DIR__ . '/../../shared_test_functions.php';

use AriStasisApp\Model\{Message\MissingParams};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMissingParams;

/**
 * Class MissingParamsTest
 *
 * @package AriStasisApp\Tests\Model\Message
 */
final class MissingParamsTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var MissingParams $missingParams
         */
        $missingParams = mapMissingParams();
        $this->assertSame(['ExampleParam', 'ExampleParam2'], $missingParams->getParams());
    }
}