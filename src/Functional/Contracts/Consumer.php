<?php

namespace Smpl\Functional\Contracts;

/**
 * Consumer Contract
 *
 * This contract represents an operation that consumes a single input value, and
 * returns nothing. Implementations are expected to operate via side effects, so
 * cannot be pure.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Contracts\Func<P, void>
 *
 * @phpstan-impure
 */
interface Consumer extends Func
{
    /**
     * Perform this operation on the given argument
     *
     * Takes an argument of type P and performs the operation this consumer
     * represents on it, returning nothing.
     *
     * @param P $value
     *
     * @return void
     */
    public function perform(mixed $value): void;
}
