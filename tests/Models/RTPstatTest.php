<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Tests\Models;


use JsonMapper_Exception;
use NgVoice\AriClient\Models\RTPstat;
use NgVoice\AriClient\Tests\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class RTPstatTest
 *
 * @package NgVoice\AriClient\Tests\Models
 * @author Ahmad Hussain <ahmad@ng-voice.com>
 */
final class RTPstatTest extends TestCase
{
    /**
     * @throws JsonMapper_Exception
     */
    public function testParametersMappedCorrectly(): void
    {
        /**
         * @var RTPstat $rtpstat
         */
        $rtpstat = Helper::mapAriResponseParametersToAriObject(
            'RTPstat',
            [
                'txjitter' => 2.34,
                'local_stdevjitter' => 4.2243,
                'local_minjitter' => 8.5323,
                'rxjitter' => 1.456,
                'rtt' => 932.33,
                'stdevrtt' => 23.112,
                'local_maxjitter' => 28.5323,
                'maxrtt' => 12.56,
                'local_normdevrxploss' => 932.33,
                'local_normdevjitter' => 12.56,
                'te_minrxploss' => 2.33,
                'txoctetcount' => 125,
                'rxoctetcount' => 33,
                'local_maxrxploss' => 12.56,
                'remote_normdevrxploss' => 12.56,
                'local_stdevrxploss' => 12.56,
                'remote_stdevjitter' => 932.33,
                'txploss' => 83,
                'remote_stdevrxploss' => 212.33,
                'remote_maxrxploss' => 212.33,
                'txcount' => 126,
                'remote_minjitter' => 8.33,
                'remote_maxjitter' => 212.33,
                'remote_ssrc' => 16,
                'channel_uniqueid' => 'id',
                'rxcount' => 33,
                'rxploss' => 3,
                'remote_normdevjitter' => 8.33,
                'local_ssrc' => 3,
                'minrtt' => 8.33,
                'local_minrxploss' => 32.3,
                'normdevrtt' => 8.33
            ]
        );
        $this->assertSame(2.34, $rtpstat->getTxjitter());
        $this->assertSame(4.2243, $rtpstat->getLocalStdevjitter());
        $this->assertSame(8.5323, $rtpstat->getLocalMinjitter());
        $this->assertSame(1.456, $rtpstat->getRxjitter());
        $this->assertSame(932.33, $rtpstat->getRtt());
        $this->assertSame(23.112, $rtpstat->getStdevrtt());
        $this->assertSame(28.5323, $rtpstat->getLocalMaxjitter());
        $this->assertSame(12.56, $rtpstat->getMaxrtt());
        $this->assertSame(932.33, $rtpstat->getLocalNormdevrxploss());
        $this->assertSame(2.33, $rtpstat->getTeMinrxploss());
        $this->assertSame(125, $rtpstat->getTxoctetcount());
        $this->assertSame(33, $rtpstat->getRxoctetcount());
        $this->assertSame(12.56, $rtpstat->getLocalMaxrxploss());
        $this->assertSame(12.56, $rtpstat->getRemoteNormdevrxploss());
        $this->assertSame(212.33, $rtpstat->getRemoteStdevrxploss());
        $this->assertSame(12.56, $rtpstat->getLocalStdevrxploss());
        $this->assertSame(932.33, $rtpstat->getRemoteStdevjitter());
        $this->assertSame(12.56, $rtpstat->getLocalNormdevjitter());
        $this->assertSame(83, $rtpstat->getTxploss());
        $this->assertSame(212.33, $rtpstat->getRemoteMaxrxploss());
        $this->assertSame(8.33, $rtpstat->getRemoteMinjitter());
        $this->assertSame(126, $rtpstat->getTxcount());
        $this->assertSame(212.33, $rtpstat->getRemoteMaxjitter());
        $this->assertSame(16, $rtpstat->getRemoteSsrc());
        $this->assertSame('id', $rtpstat->getChannelUniqueid());
        $this->assertSame(33, $rtpstat->getRxcount());
        $this->assertSame(3, $rtpstat->getRxploss());
        $this->assertSame(8.33, $rtpstat->getRemoteNormdevjitter());
        $this->assertSame(3, $rtpstat->getLocalSsrc());
        $this->assertSame(8.33, $rtpstat->getMinrtt());
        $this->assertSame(32.3, $rtpstat->getLocalMinrxploss());
        $this->assertSame(8.33, $rtpstat->getNormdevrtt());
    }
}
