<?php

/** @copyright 2020 ng-voice GmbH */

declare(strict_types=1);

namespace OpiyOrg\AriClient\Model;

/**
 * Effective user/group id
 *
 * @package OpiyOrg\AriClient\Model
 *
 * @author Lukas Stermann <lukas@ng-voice.com>
 */
final class SetId implements ModelInterface
{
    private string $group;

    private string $user;

    /**
     * Effective group id.
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Effective user id.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }
}
