<?php

namespace Smpl\Collections\Contracts;

/**
 * Pair Contract
 *
 * This contract represents a pair with a {@see \Smpl\Collections\Contracts\Map},
 * containing the value and the key it was mapped with.
 *
 * @template K of mixed
 * @template V of mixed
 */
interface Pair
{
    /**
     * Get the key for the pair
     *
     * Returns the key used to map this pair's value within a map.
     *
     * @return K
     */
    public function key(): mixed;

    /**
     * Get the value for the pair
     *
     * Returns the value mapped to this pair's key within a map.
     *
     * @return V
     */
    public function value(): mixed;
}
