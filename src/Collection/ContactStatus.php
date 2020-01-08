<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Collection;

/**
 * Collection of Asterisk contact statuses.
 *
 * @package NgVoice\AriClient\Collection
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
