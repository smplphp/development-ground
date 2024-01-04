<?php

namespace Smpl\Functional\Contracts;

/**
 * Func Contract
 *
 * This contract is the core of the functional utility library, and represents
 * a simple function that can be applied to value.
 *
 * @template P of mixed
 * @template R of mixed
 */
interface Func
{
    /**
     * Apply this function to the provided value
     *
     * Takes an argument of type P and returns a value of type R.
     *
     * @param P $value
     *
     * @return R
     */
    public function apply(mixed $value): mixed;

    /**
     * Return a composed function of the provided and this one
     *
     * Takes an argument of Func<T, P> that runs the value through the provided function,
     * and then runs its return value through this one.
     *
     * @template T of mixed
     *
     * @param \Smpl\Functional\Contracts\Func<T, P> $before
     *
     * @return \Smpl\Functional\Contracts\Func<T, R>
     */
    public function compose(Func $before): Func;
}
