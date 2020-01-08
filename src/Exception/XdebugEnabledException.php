<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Exception;

use RuntimeException;

/**
 * Wrap a RuntimeException in case the PHP Xdebug extension
 * is still enabled in a production environment.
 *
 * @package NgVoice\AriClient\Exception
 *
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
class XdebugEnabledException extends RuntimeException
{
}
