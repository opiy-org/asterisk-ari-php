<?php
/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


/**
 * Notification that another WebSocket has taken over for an application.
 * An application may only be subscribed to by a single WebSocket at a time.
 * If multiple WebSockets attempt to subscribe to the same application,
 * the newer WebSocket wins, and the older one receives this event.
 *
 * @package AriStasisApp\models\messages
 */
class ApplicationReplaced extends Event
{
}