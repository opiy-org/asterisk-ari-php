<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;

/**
 * A statistics of a RTP.
 *
 * @package NgVoice\AriClient\Models
 */
final class RTPstat implements Model
{
    /**
     * @var double Jitter on transmitted packets.
     */
    private $txjitter;

    /**
     * @var double Standard deviation jitter on local side.
     */
    private $local_stdevjitter;

    /**
     * @var double Minimum jitter on local side.
     */
    private $local_minjitter;

    /**
     * @var double Jitter on received packets.
     */
    private $rxjitter;

    /**
     * @var double Total round trip time.
     */
    private $rtt;

    /**
     * @var double Standard deviation round trip time.
     */
    private $stdevrtt;

    /**
     * @var double Maximum jitter on local side.
     */
    private $local_maxjitter;

    /**
     * @var double Maximum round trip time.
     */
    private $maxrtt;

    /**
     * @var double Average number of packets lost on local side.
     */
    private $local_normdevrxploss;

    /**
     * @var double Minimum number of packets lost on remote side.
     */
    private $te_minrxploss;

    /**
     * @var int Number of octets transmitted.
     */
    private $txoctetcount;

    /**
     * @var int Number of octets received.
     */
    private $rxoctetcount;

    /**
     * @var double Maximum number of packets lost on local side.
     */
    private $local_maxrxploss;

    /**
     * @var double Average number of packets lost on remote side.
     */
    private $remote_normdevrxploss;

    /**
     * @var double Standard deviation packets lost on local side.
     */
    private $local_stdevrxploss;

    /**
     * @var double Standard deviation jitter on remote side.
     */
    private $remote_stdevjitter;

    /**
     * @var double Average jitter on local side.
     */
    private $local_normdevjitter;

    /**
     * @var int Number of transmitted packets lost.
     */
    private $txploss;

    /**
     * @var double Standard deviation packets lost on remote side.
     */
    private $remote_stdevrxploss;

    /**
     * @var double Maximum number of packets lost on remote side.
     */
    private $remote_maxrxploss;

    /**
     * @var int Number of packets transmitted.
     */
    private $txcount;

    /**
     * @var double Minimum jitter on remote side.
     */
    private $remote_minjitter;

    /**
     * @var double Maximum jitter on remote side.
     */
    private $remote_maxjitter;

    /**
     * @var int Their SSRC.
     */
    private $remote_ssrc;

    /**
     * @var string The Asterisk channel's unique ID that owns this instance.
     */
    private $channel_uniqueid;

    /**
     * @var int Number of packets received.
     */
    private $rxcount;

    /**
     * @var int Number of received packets lost.
     */
    private $rxploss;

    /**
     * @var double Average jitter on remote side.
     */
    private $remote_normdevjitter;

    /**
     * @var int Our SSRC.
     */
    private $local_ssrc;

    /**
     * @var double Minimum round trip time.
     */
    private $minrtt;

    /**
     * @var double Minimum number of packets lost on local side.
     */
    private $local_minrxploss;

    /**
     * @var double Average round trip time.
     */
    private $normdevrtt;

    /**
     * @return float
     */
    public function getTxjitter(): float
    {
        return $this->txjitter;
    }

    /**
     * @param float $txjitter
     */
    public function setTxjitter(float $txjitter): void
    {
        $this->txjitter = $txjitter;
    }

    /**
     * @return float
     */
    public function getLocalStdevjitter(): float
    {
        return $this->local_stdevjitter;
    }

    /**
     * @param float $local_stdevjitter
     */
    public function setLocalStdevjitter(float $local_stdevjitter): void
    {
        $this->local_stdevjitter = $local_stdevjitter;
    }

    /**
     * @return float
     */
    public function getLocalMinjitter(): float
    {
        return $this->local_minjitter;
    }

    /**
     * @param float $local_minjitter
     */
    public function setLocalMinjitter(float $local_minjitter): void
    {
        $this->local_minjitter = $local_minjitter;
    }

    /**
     * @return float
     */
    public function getRxjitter(): float
    {
        return $this->rxjitter;
    }

    /**
     * @param float $rxjitter
     */
    public function setRxjitter(float $rxjitter): void
    {
        $this->rxjitter = $rxjitter;
    }

    /**
     * @return float
     */
    public function getRtt(): float
    {
        return $this->rtt;
    }

    /**
     * @param float $rtt
     */
    public function setRtt(float $rtt): void
    {
        $this->rtt = $rtt;
    }

    /**
     * @return float
     */
    public function getStdevrtt(): float
    {
        return $this->stdevrtt;
    }

    /**
     * @param float $stdevrtt
     */
    public function setStdevrtt(float $stdevrtt): void
    {
        $this->stdevrtt = $stdevrtt;
    }

    /**
     * @return float
     */
    public function getLocalMaxjitter(): float
    {
        return $this->local_maxjitter;
    }

    /**
     * @param float $local_maxjitter
     */
    public function setLocalMaxjitter(float $local_maxjitter): void
    {
        $this->local_maxjitter = $local_maxjitter;
    }

    /**
     * @return float
     */
    public function getMaxrtt(): float
    {
        return $this->maxrtt;
    }

    /**
     * @param float $maxrtt
     */
    public function setMaxrtt(float $maxrtt): void
    {
        $this->maxrtt = $maxrtt;
    }

    /**
     * @return float
     */
    public function getLocalNormdevrxploss(): float
    {
        return $this->local_normdevrxploss;
    }

    /**
     * @param float $local_normdevrxploss
     */
    public function setLocalNormdevrxploss(float $local_normdevrxploss): void
    {
        $this->local_normdevrxploss = $local_normdevrxploss;
    }

    /**
     * @return float
     */
    public function getTeMinrxploss(): float
    {
        return $this->te_minrxploss;
    }

    /**
     * @param float $te_minrxploss
     */
    public function setTeMinrxploss(float $te_minrxploss): void
    {
        $this->te_minrxploss = $te_minrxploss;
    }

    /**
     * @return int
     */
    public function getTxoctetcount(): int
    {
        return $this->txoctetcount;
    }

    /**
     * @param int $txoctetcount
     */
    public function setTxoctetcount(int $txoctetcount): void
    {
        $this->txoctetcount = $txoctetcount;
    }

    /**
     * @return int
     */
    public function getRxoctetcount(): int
    {
        return $this->rxoctetcount;
    }

    /**
     * @param int $rxoctetcount
     */
    public function setRxoctetcount(int $rxoctetcount): void
    {
        $this->rxoctetcount = $rxoctetcount;
    }

    /**
     * @return float
     */
    public function getLocalMaxrxploss(): float
    {
        return $this->local_maxrxploss;
    }

    /**
     * @param float $local_maxrxploss
     */
    public function setLocalMaxrxploss(float $local_maxrxploss): void
    {
        $this->local_maxrxploss = $local_maxrxploss;
    }

    /**
     * @return float
     */
    public function getRemoteNormdevrxploss(): float
    {
        return $this->remote_normdevrxploss;
    }

    /**
     * @param float $remote_normdevrxploss
     */
    public function setRemoteNormdevrxploss(float $remote_normdevrxploss): void
    {
        $this->remote_normdevrxploss = $remote_normdevrxploss;
    }

    /**
     * @return float
     */
    public function getLocalStdevrxploss(): float
    {
        return $this->local_stdevrxploss;
    }

    /**
     * @param float $local_stdevrxploss
     */
    public function setLocalStdevrxploss(float $local_stdevrxploss): void
    {
        $this->local_stdevrxploss = $local_stdevrxploss;
    }

    /**
     * @return float
     */
    public function getRemoteStdevjitter(): float
    {
        return $this->remote_stdevjitter;
    }

    /**
     * @param float $remote_stdevjitter
     */
    public function setRemoteStdevjitter(float $remote_stdevjitter): void
    {
        $this->remote_stdevjitter = $remote_stdevjitter;
    }

    /**
     * @return float
     */
    public function getLocalNormdevjitter(): float
    {
        return $this->local_normdevjitter;
    }

    /**
     * @param float $local_normdevjitter
     */
    public function setLocalNormdevjitter(float $local_normdevjitter): void
    {
        $this->local_normdevjitter = $local_normdevjitter;
    }

    /**
     * @return int
     */
    public function getTxploss(): int
    {
        return $this->txploss;
    }

    /**
     * @param int $txploss
     */
    public function setTxploss(int $txploss): void
    {
        $this->txploss = $txploss;
    }

    /**
     * @return float
     */
    public function getRemoteStdevrxploss(): float
    {
        return $this->remote_stdevrxploss;
    }

    /**
     * @param float $remote_stdevrxploss
     */
    public function setRemoteStdevrxploss(float $remote_stdevrxploss): void
    {
        $this->remote_stdevrxploss = $remote_stdevrxploss;
    }

    /**
     * @return float
     */
    public function getRemoteMaxrxploss(): float
    {
        return $this->remote_maxrxploss;
    }

    /**
     * @param float $remote_maxrxploss
     */
    public function setRemoteMaxrxploss(float $remote_maxrxploss): void
    {
        $this->remote_maxrxploss = $remote_maxrxploss;
    }

    /**
     * @return int
     */
    public function getTxcount(): int
    {
        return $this->txcount;
    }

    /**
     * @param int $txcount
     */
    public function setTxcount(int $txcount): void
    {
        $this->txcount = $txcount;
    }

    /**
     * @return float
     */
    public function getRemoteMinjitter(): float
    {
        return $this->remote_minjitter;
    }

    /**
     * @param float $remote_minjitter
     */
    public function setRemoteMinjitter(float $remote_minjitter): void
    {
        $this->remote_minjitter = $remote_minjitter;
    }

    /**
     * @return float
     */
    public function getRemoteMaxjitter(): float
    {
        return $this->remote_maxjitter;
    }

    /**
     * @param float $remote_maxjitter
     */
    public function setRemoteMaxjitter(float $remote_maxjitter): void
    {
        $this->remote_maxjitter = $remote_maxjitter;
    }

    /**
     * @return int
     */
    public function getRemoteSsrc(): int
    {
        return $this->remote_ssrc;
    }

    /**
     * @param int $remote_ssrc
     */
    public function setRemoteSsrc(int $remote_ssrc): void
    {
        $this->remote_ssrc = $remote_ssrc;
    }

    /**
     * @return string
     */
    public function getChannelUniqueid(): string
    {
        return $this->channel_uniqueid;
    }

    /**
     * @param string $channel_uniqueid
     */
    public function setChannelUniqueid(string $channel_uniqueid): void
    {
        $this->channel_uniqueid = $channel_uniqueid;
    }

    /**
     * @return int
     */
    public function getRxcount(): int
    {
        return $this->rxcount;
    }

    /**
     * @param int $rxcount
     */
    public function setRxcount(int $rxcount): void
    {
        $this->rxcount = $rxcount;
    }

    /**
     * @return int
     */
    public function getRxploss(): int
    {
        return $this->rxploss;
    }

    /**
     * @param int $rxploss
     */
    public function setRxploss(int $rxploss): void
    {
        $this->rxploss = $rxploss;
    }

    /**
     * @return float
     */
    public function getRemoteNormdevjitter(): float
    {
        return $this->remote_normdevjitter;
    }

    /**
     * @param float $remote_normdevjitter
     */
    public function setRemoteNormdevjitter(float $remote_normdevjitter): void
    {
        $this->remote_normdevjitter = $remote_normdevjitter;
    }

    /**
     * @return int
     */
    public function getLocalSsrc(): int
    {
        return $this->local_ssrc;
    }

    /**
     * @param int $local_ssrc
     */
    public function setLocalSsrc(int $local_ssrc): void
    {
        $this->local_ssrc = $local_ssrc;
    }

    /**
     * @return float
     */
    public function getMinrtt(): float
    {
        return $this->minrtt;
    }

    /**
     * @param float $minrtt
     */
    public function setMinrtt(float $minrtt): void
    {
        $this->minrtt = $minrtt;
    }

    /**
     * @return float
     */
    public function getLocalMinrxploss(): float
    {
        return $this->local_minrxploss;
    }

    /**
     * @param float $local_minrxploss
     */
    public function setLocalMinrxploss(float $local_minrxploss): void
    {
        $this->local_minrxploss = $local_minrxploss;
    }

    /**
     * @return float
     */
    public function getNormdevrtt(): float
    {
        return $this->normdevrtt;
    }

    /**
     * @param float $normdevrtt
     */
    public function setNormdevrtt(float $normdevrtt): void
    {
        $this->normdevrtt = $normdevrtt;
    }
}
