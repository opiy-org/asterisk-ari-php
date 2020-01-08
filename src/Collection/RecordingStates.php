<?php

/**
 * @copyright 2020 ng-voice GmbH
 *
 * @noinspection UnknownInspectionInspection Plugin [EA] does not
 * recognize the noinspection annotation of PhpStorm
 * @noinspection RedundantSuppression
 * @noinspection PhpUnused Some of these constants are just helpful for a user,
 * not for the library itself
 */

declare(strict_types=1);

namespace NgVoice\AriClient\Collection;

/**
 * Collection of possible Asterisk recording states.
 *
 * @package NgVoice\AriClient\Collection
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class RecordingStates
{
    public const QUEUED = 'queued';

    public const RECORDING = 'recording';

    public const PAUSED = 'paused';

    public const DONE = 'done';

    public const FAILED = 'failed';

    public const CANCELED = 'canceled';
}
