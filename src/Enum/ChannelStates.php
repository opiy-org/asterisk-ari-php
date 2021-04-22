<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection Plugin [EA] does not
 * recognize the noinspection annotation of PhpStorm
 * @noinspection PhpUnused Some of these constants are just helpful for a user,
 * not for the library itself
 */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Enum;

/**
 * Enum of possible Asterisk channel states.
 *
 * @package OpiyOrg\AriClient\Enum
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ChannelStates
{
    public const DOWN = 'Down';

    public const RESERVED = 'Rsrved';

    public const OFF_HOOK = 'OffHook';

    public const DIALING = 'Dialing';

    public const RING = 'Ring';

    public const RINGING = 'Ringing';

    public const UP = 'Up';

    public const BUSY = 'Busy';

    public const DIALING_OFF_HOOK = 'Dialing OffHook';

    public const PRE_RING = 'Pre-ring';

    public const UNKNOWN = 'Unknown';
}
