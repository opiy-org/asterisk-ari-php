<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models\messages;


use AriStasisApp\models\Endpoint;
use AriStasisApp\models\TextMessage;

/**
 * A text message was received from an endpoint.
 *
 * @package AriStasisApp\models\messages
 */
class TextMessageReceived extends Event
{
    /**
     * @var TextMessage A text message was received from an endpoint.
     */
    private $message;

    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @return TextMessage
     */
    public function getMessage(): TextMessage
    {
        return $this->message;
    }

    /**
     * @param TextMessage $message
     */
    public function setMessage(TextMessage $message): void
    {
        $this->message = $message;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    /**
     * @param Endpoint $endpoint
     */
    public function setEndpoint(Endpoint $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
}