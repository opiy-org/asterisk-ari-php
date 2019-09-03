<?php

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models\Message;

use NgVoice\AriClient\Models\{Endpoint, TextMessage};

/**
 * A text message was received from an endpoint.
 *
 * @package NgVoice\AriClient\Models\Message
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class TextMessageReceived extends Event
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
