<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

declare(strict_types=1);

namespace AriStasisApp\Tests\models;


require_once __DIR__ . '/../shared_test_functions.php';

use AriStasisApp\models\{Dialed};
use PHPUnit\Framework\TestCase;

/**
 * Class DialedTest
 *
 * @package AriStasisApp\Tests\models
 */
final class DialedTest extends TestCase
{
    /**
     */
    public function testParametersMappedCorrectly(): void
    {
        $this->assertInstanceOf(Dialed::class, new Dialed());
    }
}