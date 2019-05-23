<?php

/**
 * @copyright 2019 ng-voice GmbH
 * @author Lukas Stermann <lukas@ng-voice.com>
 */

namespace NgVoice\AriClient\Models\Message;

/**
 * Error event sent when required params are missing.
 *
 * @package NgVoice\AriClient\Models\Message
 */
final class MissingParams extends Message
{
    /**
     * @var string[] A list of the missing parameters
     */
    private $params;

    /**
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string[] $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}
