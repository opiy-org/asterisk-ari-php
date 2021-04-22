<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * A statistics of a RTP.
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class RTPstat implements ModelInterface
{
    private string $channelUniqueid;

    private ?float $localMaxjitter = null;

    private ?float $localMaxrxploss = null;

    private ?float $localMinjitter = null;

    private ?float $localMinrxploss = null;

    private ?float $localNormdevjitter = null;

    private ?float $localNormdevrxploss = null;

    private int $localSsrc;

    private ?float $localStdevjitter = null;

    private ?float $localStdevrxploss = null;

    private ?float $maxrtt = null;

    private ?float $minrtt = null;

    private ?float $normdevrtt = null;

    private ?float $remoteMaxjitter = null;

    private ?float $remoteMaxrxploss = null;

    private ?float $remoteMinjitter = null;

    private ?float $remoteMinrxploss = null;

    private ?float $remoteNormdevjitter = null;

    private ?float $remoteNormdevrxploss = null;

    private int $remoteSsrc;

    private ?float $remoteStdevjitter = null;

    private ?float $remoteStdevrxploss = null;

    private ?float $rtt = null;

    private int $rxcount;

    private ?float $rxjitter = null;

    private int $rxoctetcount;

    private int $rxploss;

    private ?float $stdevrtt = null;

    private int $txcount;

    private ?float $txjitter = null;

    private int $txoctetcount;

    private int $txploss;

    /**
     * The Asterisk channel's unique ID that owns this instance.
     *
     * @return string
     */
    public function getChannelUniqueid(): string
    {
        return $this->channelUniqueid;
    }

    /**
     * Maximum jitter on local side.
     *
     * @return float|null
     */
    public function getLocalMaxjitter(): ?float
    {
        return $this->localMaxjitter;
    }

    /**
     * Maximum number of packets lost on local side.
     *
     * @return float|null
     */
    public function getLocalMaxrxploss(): ?float
    {
        return $this->localMaxrxploss;
    }

    /**
     * Minimum jitter on local side.
     *
     * @return float|null
     */
    public function getLocalMinjitter(): ?float
    {
        return $this->localMinjitter;
    }

    /**
     * Minimum number of packets lost on local side.
     *
     * @return float|null
     */
    public function getLocalMinrxploss(): ?float
    {
        return $this->localMinrxploss;
    }

    /**
     * Average jitter on local side.
     *
     * @return float|null
     */
    public function getLocalNormdevjitter(): ?float
    {
        return $this->localNormdevjitter;
    }

    /**
     * Average number of packets lost on local side.
     *
     * @return float|null
     */
    public function getLocalNormdevrxploss(): ?float
    {
        return $this->localNormdevrxploss;
    }

    /**
     * Our SSRC.
     *
     * @return int
     */
    public function getLocalSsrc(): int
    {
        return $this->localSsrc;
    }

    /**
     * Standard deviation jitter on local side.
     *
     * @return float|null
     */
    public function getLocalStdevjitter(): ?float
    {
        return $this->localStdevjitter;
    }

    /**
     * Standard deviation packets lost on local side.
     *
     * @return float|null
     */
    public function getLocalStdevrxploss(): ?float
    {
        return $this->localStdevrxploss;
    }

    /**
     * Maximum round trip time.
     *
     * @return float|null
     */
    public function getMaxrtt(): ?float
    {
        return $this->maxrtt;
    }

    /**
     * Minimum round trip time.
     *
     * @return float|null
     */
    public function getMinrtt(): ?float
    {
        return $this->minrtt;
    }

    /**
     * Average round trip time.
     *
     * @return float|null
     */
    public function getNormdevrtt(): ?float
    {
        return $this->normdevrtt;
    }

    /**
     * Maximum jitter on remote side.
     *
     * @return float|null
     */
    public function getRemoteMaxjitter(): ?float
    {
        return $this->remoteMaxjitter;
    }

    /**
     * Maximum number of packets lost on remote side.
     *
     * @return float|null
     */
    public function getRemoteMaxrxploss(): ?float
    {
        return $this->remoteMaxrxploss;
    }

    /**
     * Minimum jitter on remote side.
     *
     * @return float|null
     */
    public function getRemoteMinjitter(): ?float
    {
        return $this->remoteMinjitter;
    }

    /**
     * Minimum number of packets lost on remote side.
     *
     * @return float|null
     */
    public function getRemoteMinrxploss(): ?float
    {
        return $this->remoteMinrxploss;
    }

    /**
     * Average jitter on remote side.
     *
     * @return float|null
     */
    public function getRemoteNormdevjitter(): ?float
    {
        return $this->remoteNormdevjitter;
    }

    /**
     * Average number of packets lost on remote side.
     *
     * @return float|null
     */
    public function getRemoteNormdevrxploss(): ?float
    {
        return $this->remoteNormdevrxploss;
    }

    /**
     * Their SSRC.
     *
     * @return int
     */
    public function getRemoteSsrc(): int
    {
        return $this->remoteSsrc;
    }

    /**
     * Standard deviation jitter on remote side.
     *
     * @return float|null
     */
    public function getRemoteStdevjitter(): ?float
    {
        return $this->remoteStdevjitter;
    }

    /**
     * Standard deviation packets lost on remote side.
     *
     * @return float|null
     */
    public function getRemoteStdevrxploss(): ?float
    {
        return $this->remoteStdevrxploss;
    }

    /**
     * Total round trip time.
     *
     * @return float|null
     */
    public function getRtt(): ?float
    {
        return $this->rtt;
    }

    /**
     * Number of packets received.
     *
     * @return int
     */
    public function getRxcount(): int
    {
        return $this->rxcount;
    }

    /**
     * Jitter on received packets.
     *
     * @return float|null
     */
    public function getRxjitter(): ?float
    {
        return $this->rxjitter;
    }

    /**
     * Number of octets received.
     *
     * @return int
     */
    public function getRxoctetcount(): int
    {
        return $this->rxoctetcount;
    }

    /**
     * Number of received packets lost.
     *
     * @return int
     */
    public function getRxploss(): int
    {
        return $this->rxploss;
    }

    /**
     * Standard deviation round trip time.
     *
     * @return float|null
     */
    public function getStdevrtt(): ?float
    {
        return $this->stdevrtt;
    }

    /**
     * Number of packets transmitted.
     *
     * @return int
     */
    public function getTxcount(): int
    {
        return $this->txcount;
    }

    /**
     * Jitter on transmitted packets.
     *
     * @return float|null
     */
    public function getTxjitter(): ?float
    {
        return $this->txjitter;
    }

    /**
     * Number of octets transmitted.
     *
     * @return int
     */
    public function getTxoctetcount(): int
    {
        return $this->txoctetcount;
    }

    /**
     * Number of transmitted packets lost.
     *
     * @return int
     */
    public function getTxploss(): int
    {
        return $this->txploss;
    }
}
