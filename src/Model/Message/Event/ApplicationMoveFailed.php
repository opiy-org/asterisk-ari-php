<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message\Event;

use OpiyOrg\AriClient\Model\Channel;

/**
 * Notification that trying to move a channel to another Stasis application failed.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ApplicationMoveFailed extends Event
{
    /**
     * @var array<int, mixed>
     */
    private array $args = [];

    private string $destination;

    private Channel $channel;

    /**
     * Arguments to the application
     *
     * @return array<int, string>
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
