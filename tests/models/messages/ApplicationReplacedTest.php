<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 21.02.19
 * Time: 19:25
 */

namespace AriStasisApp\Tests\models\messages;

use AriStasisApp\models\{messages\ApplicationReplaced};
use PHPUnit\Framework\TestCase;
use function AriStasisApp\Tests\mapMessageParametersToAriObject;

require_once __DIR__ . '/../../shared_test_functions.php';

/**
 * Class ApplicationReplacedTest
 *
 * @package AriStasisApp\Tests\models
 */
final class ApplicationReplacedTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var ApplicationReplaced $dialed
         */
        $dialed = mapMessageParametersToAriObject(
            'ApplicationReplaced',
            [
            ]
        );
        $this->assertInstanceOf(ApplicationReplaced::class, $dialed);
    }
}