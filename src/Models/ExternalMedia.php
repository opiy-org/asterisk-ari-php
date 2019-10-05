<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;


/**
 * ExternalMedia session.
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class ExternalMedia implements ModelInterface
{
    /**
     * @var string The local ip address used
     */
    private $local_address;

    /**
     * @var Channel The Asterisk channel representing the external media
     */
    private $channel;

    /**
     * @var int The local ip port used
     */
    private $local_port;

    /**
     * @return string The local ip address used
     */
    public function getLocalAddress(): string
    {
        return $this->local_address;
    }

    /**
     * @param string $local_address The local ip address used
     */
    public function setLocalAddress(string $local_address): void
    {
        $this->local_address = $local_address;
    }

    /**
     * @return Channel The Asterisk channel representing the external media
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel The Asterisk channel representing the external media
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @return int The local ip port used
     */
    public function getLocalPort(): int
    {
        return $this->local_port;
    }

    /**
     * @param int $local_port The local ip port used
     */
    public function setLocalPort(int $local_port): void
    {
        $this->local_port = $local_port;
    }
}
