<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;

/**
 * Class AsteriskPing
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class AsteriskPing implements Model
{
    /**
     * The timestamp string of request received time
     *
     * @var string $timestamp
     */
    private $timestamp;

    /**
     * Always string value is pong
     *
     * @var string $ping
     */
    private $ping;

    /**
     * Asterisk id info
     *
     * @var string $asterisk_id
     */
    private $asterisk_id;

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getPing(): string
    {
        return $this->ping;
    }

    /**
     * @param string $ping
     */
    public function setPing(string $ping): void
    {
        $this->ping = $ping;
    }

    /**
     * @return string
     */
    public function getAsteriskId(): string
    {
        return $this->asterisk_id;
    }

    /**
     * @param string $asterisk_id
     */
    public function setAsteriskId(string $asterisk_id): void
    {
        $this->asterisk_id = $asterisk_id;
    }
}
