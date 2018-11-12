<?php

/**
 * @author Lukas Stermann
 * @author Rick Barentin
 * @copyright ng-voice GmbH (2018)
 *
 *
 * By calling this script, the swagger-ui will be generated.
 *
 * TODO: Needs further investigation
 */

require_once 'vendor/autoload.php';


$openapi = \OpenApi\scan(__DIR__ . '/src/rest_clients');
header('Content-Type: application/x-yaml');

echo $openapi->toYaml();