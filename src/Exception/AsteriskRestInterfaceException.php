<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Exception;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * AsteriskRestInterfaceException wraps a GuzzleException
 * in order to make the context of an exception during the communication
 * with the Asterisk server clearer in the code.
 *
 * @package NgVoice\AriClient\Exception
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class AsteriskRestInterfaceException extends Exception
{
    /**
     * The thrown exception.
     *
     * @var GuzzleException
     */
    private $guzzleException;

    /**
     * AsteriskRestInterfaceException constructor.
     *
     * @param GuzzleException $guzzleException The thrown exception.
     */
    public function __construct(GuzzleException $guzzleException)
    {
        parent::__construct(
            $guzzleException->getMessage(),
            $guzzleException->getCode(),
            $guzzleException
        );

        $this->guzzleException = $guzzleException;
    }

    /**
     * Get the GuzzleException
     *
     * @return GuzzleException
     */
    public function getGuzzleException(): GuzzleException
    {
        return $this->guzzleException;
    }
}
