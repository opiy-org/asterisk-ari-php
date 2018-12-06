<?php

/**
 * @author Lukas Stermann
 * @author Rick Barenthin
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\models;


/**
 * A media file that may be played back.
 *
 * @package AriStasisApp\models
 */
class Sound
{
    /**
     * @var string Text description of the sound, usually the words spoken.
     */
    private $text;

    /**
     * @var string Sound's identifier.
     */
    private $id;

    /**
     * @var array The formats and languages in which this sound is available. TODO: List[FormatLangPair]
     */
    private $formats;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @param array $formats
     */
    public function setFormats(array $formats): void
    {
        $this->formats = $formats;
    }
}