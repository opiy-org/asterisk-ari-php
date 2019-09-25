<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Exception;

use RuntimeException;

/**
 * EnvironmentConfigurationException wraps a RuntimeException to make
 * it more precise when we having a exception regarding environment configuration
 * @package NgVoice\AriClient\Exception
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class EnvironmentConfigurationException extends RuntimeException
{
}
