<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2019)
 */

namespace AriStasisApp\models\messages;


/**
 * Error event sent when required params are missing.
 *
 * @package AriStasisApp\models\messages
 */
class MissingParams extends Message
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