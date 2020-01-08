<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Model\Message\Event;

/**
 * Notification that another WebSocket has taken over for an application.
 * An application may only be subscribed to by a single WebSocket at a time.
 * If multiple WebSockets attempt to subscribe to the same application,
 * the newer WebSocket wins, and the older one receives this event.
 *
 * @package NgVoice\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ApplicationReplaced extends Event
{
}
