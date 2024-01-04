<?php

namespace Smpl\Collections\Contracts;

/**
 * Identifiable Contract
 *
 * This contract is for use on objects that wish to provide their own identity.
 * Identities are used as array keys where necessary, as well as for the purpose
 * of comparison.
 */
interface Identifiable
{
    /**
     * Get the identity of this object
     *
     * Returns a string or integer that represents the identity of this object.
     *
     * @return string|int
     */
    public function identity(): string|int;
}
