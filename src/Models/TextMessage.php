<?php

/** @copyright 2019 ng-voice GmbH */

namespace NgVoice\AriClient\Models;


/**
 * A text message.
 *
 * @package NgVoice\AriClient\Models
 */
final class TextMessage implements Model
{
    /**
     * @var string The text of the message.
     */
    private $body;

    /**
     * @var string A technology specific URI specifying the destination of the message.
     * Valid technologies include sip, pjsip, and xmp. The destination of a message should be an endpoint.
     */
    private $to;

    /**
     * @var TextMessageVariable[] Technology specific key/value pairs associated with the message.
     */
    private $variables;

    /**
     * @var string A technology specific URI specifying the source of the message.
     * For sip and pjsip technologies, any SIP URI can be specified. For xmpp,
     * the URI must correspond to the client connection being used to send the message.
     */
    private $from;

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return TextMessageVariable[]
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @param TextMessageVariable[] $variables
     */
    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }
}
