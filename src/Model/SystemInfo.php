<?php

/**
 * @author Lukas Stermann
 * @copyright ng-voice GmbH (2018)
 */

namespace AriStasisApp\Model;


/**
 * Info about Asterisk.
 *
 * @package AriStasisApp\Model
 */
class SystemInfo
{
    /**
     * @var string
     */
    private $entity_id;

    /**
     * @var string Asterisk version.
     */
    private $version;

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entity_id;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId(string $entityId): void
    {
        $this->entity_id = $entityId;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
}