<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model\Message;

/**
 * Error event sent when required params are missing.
 *
 * @package OpiyOrg\AriClient\Model\Message\Event
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class MissingParams extends Message
{
    /**
     * @var array<int, string>
     */
    private array $params;

    /**
     * A list of the missing parameters.
     *
     * @return array<int, string>
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
