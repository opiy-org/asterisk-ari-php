<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection Plugin [EA] does not
 * recognize the noinspection annotation of PhpStorm.
 * @noinspection PhpUnused Some constants are helpful
 * for users and not for the library itself.
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Enum;

/**
 * Enum of Asterisk contact statuses.
 *
 * @package NgVoice\AriClient\Enum
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ContactStatus
{
    public const UNREACHABLE = 'Unreachable';

    public const REACHABLE = 'Reachable';

    public const UNKNOWN = 'Unknown';

    public const NON_QUALIFIED = 'NonQualified';

    public const REMOVED = 'Removed';
}
