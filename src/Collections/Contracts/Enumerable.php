<?php

namespace Smpl\Collections\Contracts;

use Countable;
use IteratorAggregate;

/**
 * Enumerable Contract
 *
 * This contract represents the base of the collection component, providing a
 * shared contract that allows for the counting and iteration of a collection.
 *
 * @template K of mixed
 * @template V of mixed
 *
 * @extends IteratorAggregate<K, V>
 */
interface Enumerable extends Countable, IteratorAggregate
{
    /**
     * Convert this object into an array
     *
     * Returns an array consisting of the values stored within this enumerable object.
     * The keys of the array will typically be of type K, except in cases where K is
     * not a valid array-key.
     *
     * @return array<K|array-key, V>
     */
    public function toArray(): array;
}
