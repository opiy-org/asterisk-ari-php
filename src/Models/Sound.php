<?php

/**
 * The JSONMapper library needs the full name path of
 * a class, so there are no imports used instead.
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

/** @copyright 2019 ng-voice GmbH */

declare(strict_types=1);

namespace NgVoice\AriClient\Models;


/**
 * A media file that may be played back.
 *
 * @package NgVoice\AriClient\Models
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class Sound implements ModelInterface
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
     * @var FormatLangPair[] The formats and languages in which this sound is available.
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
     * @return FormatLangPair[]
     */
    public function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @param FormatLangPair[] $formats
     */
    public function setFormats(array $formats): void
    {
        $this->formats = $formats;
    }
}
