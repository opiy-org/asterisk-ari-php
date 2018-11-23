<?php

use AriStasisApp\Tests\amqp\AMQPPublisherTest;
use SebastianBergmann\CodeCoverage\CodeCoverage;

require_once __DIR__ . '/../vendor/autoload.php';

$coverage = new CodeCoverage;

$coverage->filter()->addDirectoryToWhitelist(__DIR__ . '/../src');


// TODO: Write the tests.
$coverage->start(new AMQPPublisherTest());

// ...


try {
    $coverage->stop();
} catch (ReflectionException $exception) {
    print_r($exception->getMessage(),true);
    exit(1);
}

//$writer = new \SebastianBergmann\CodeCoverage\Report\Clover;
//$writer->process($coverage, __DIR__ . '/coverage-reports/tmp/clover-' . date("Y-m-d-h:i:sa"). '.xml');
$writer = new SebastianBergmann\CodeCoverage\Report\PHP();
$writer->process($coverage, __DIR__ . '/coverage-reports/code-coverage-report-' . date("Y-m-d-h:i:sa"));

// Print out the results
//$writer = new \SebastianBergmann\CodeCoverage\Report\Html\Facade;
//$writer->process($coverage, __DIR__ . '/coverage-reports/code-coverage-report-' . date("Y-m-d-h:i:sa"));