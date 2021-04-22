<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Tests\Model;

use OpiyOrg\AriClient\Model\RTPstat;
use OpiyOrg\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class RTPstatTest
 *
 * @package OpiyOrg\AriClient\Tests\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class RTPstatTest extends TestCase
{
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var RTPstat $rtpStat
         */
        $rtpStat = Helper::mapOntoInstance(
            [
                'txjitter'              => 2.34,
                'local_stdevjitter'     => 4.2243,
                'local_minjitter'       => 8.5323,
                'rxjitter'              => 1.456,
                'rtt'                   => 932.33,
                'stdevrtt'              => 23.112,
                'local_maxjitter'       => 28.5323,
                'maxrtt'                => 12.56,
                'local_normdevrxploss'  => 932.33,
                'local_normdevjitter'   => 12.56,
                'remote_minrxploss'     => 2.33,
                'txoctetcount'          => 125,
                'rxoctetcount'          => 33,
                'local_maxrxploss'      => 12.56,
                'remote_normdevrxploss' => 12.56,
                'local_stdevrxploss'    => 12.56,
                'remote_stdevjitter'    => 932.33,
                'txploss'               => 83,
                'remote_stdevrxploss'   => 212.33,
                'remote_maxrxploss'     => 212.33,
                'txcount'               => 126,
                'remote_minjitter'      => 8.33,
                'remote_maxjitter'      => 212.33,
                'remote_ssrc'           => 16,
                'channel_uniqueid'      => 'id',
                'rxcount'               => 33,
                'rxploss'               => 3,
                'remote_normdevjitter'  => 8.33,
                'local_ssrc'            => 3,
                'minrtt'                => 8.33,
                'local_minrxploss'      => 32.3,
                'normdevrtt'            => 8.33,
            ],
            new RTPstat()
        );
        $this->assertSame(2.34, $rtpStat->getTxjitter());
        $this->assertSame(4.2243, $rtpStat->getLocalStdevjitter());
        $this->assertSame(8.5323, $rtpStat->getLocalMinjitter());
        $this->assertSame(1.456, $rtpStat->getRxjitter());
        $this->assertSame(932.33, $rtpStat->getRtt());
        $this->assertSame(23.112, $rtpStat->getStdevrtt());
        $this->assertSame(28.5323, $rtpStat->getLocalMaxjitter());
        $this->assertSame(12.56, $rtpStat->getMaxrtt());
        $this->assertSame(932.33, $rtpStat->getLocalNormdevrxploss());
        $this->assertSame(2.33, $rtpStat->getRemoteMinrxploss());
        $this->assertSame(125, $rtpStat->getTxoctetcount());
        $this->assertSame(33, $rtpStat->getRxoctetcount());
        $this->assertSame(12.56, $rtpStat->getLocalMaxrxploss());
        $this->assertSame(12.56, $rtpStat->getRemoteNormdevrxploss());
        $this->assertSame(212.33, $rtpStat->getRemoteStdevrxploss());
        $this->assertSame(12.56, $rtpStat->getLocalStdevrxploss());
        $this->assertSame(932.33, $rtpStat->getRemoteStdevjitter());
        $this->assertSame(12.56, $rtpStat->getLocalNormdevjitter());
        $this->assertSame(83, $rtpStat->getTxploss());
        $this->assertSame(212.33, $rtpStat->getRemoteMaxrxploss());
        $this->assertSame(8.33, $rtpStat->getRemoteMinjitter());
        $this->assertSame(126, $rtpStat->getTxcount());
        $this->assertSame(212.33, $rtpStat->getRemoteMaxjitter());
        $this->assertSame(16, $rtpStat->getRemoteSsrc());
        $this->assertSame('id', $rtpStat->getChannelUniqueid());
        $this->assertSame(33, $rtpStat->getRxcount());
        $this->assertSame(3, $rtpStat->getRxploss());
        $this->assertSame(8.33, $rtpStat->getRemoteNormdevjitter());
        $this->assertSame(3, $rtpStat->getLocalSsrc());
        $this->assertSame(8.33, $rtpStat->getMinrtt());
        $this->assertSame(32.3, $rtpStat->getLocalMinrxploss());
        $this->assertSame(8.33, $rtpStat->getNormdevrtt());
    }
}
