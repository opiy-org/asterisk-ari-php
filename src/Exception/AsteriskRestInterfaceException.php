<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Exception;

use Exception;
use Throwable;

/**
 * AsteriskRestInterfaceException wraps occurring exceptions
 * in order to make the context of an exception during the communication
 * with the ARI server clearer in the users code.
 *
 * @package OpiyOrg\AriClient\Exception
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
class AsteriskRestInterfaceException extends Exception
{
    /**
     * The thrown exception.
     */
    private Throwable $exception;

    /**
     * AsteriskRestInterfaceException constructor.
     *
     * @param Throwable $exception The thrown exception.
     */
    public function __construct(Throwable $exception)
    {
        parent::__construct(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );

        $this->exception = $exception;
    }

    /**
     * Get the GuzzleException
     *
     * @return Throwable
     */
    public function getException(): Throwable
    {
        return $this->exception;
    }
}
