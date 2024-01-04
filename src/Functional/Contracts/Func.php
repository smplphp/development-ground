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
     *  This method is a compliment of {@see self::andThen()}, but in reverse order.
     *
     * @template T of mixed
     *
     * @param \Smpl\Functional\Contracts\Func<T, P> $before
     *
     * @return \Smpl\Functional\Contracts\Func<T, R>
     */
    public function compose(Func $before): Func;

    /**
     * Return a composed function of this one and a provided one
     *
     * Takes an argument of Func<R, T> that runs the value through this function,
     * and then runs its return value through the provided.
     *
     * This method is a compliment of {@see self::compose()}, but in reverse order.
     *
     * @template T of mixed
     *
     * @param \Smpl\Functional\Contracts\Func<R, T> $after
     *
     * @return \Smpl\Functional\Contracts\Func<P, T>
     */
    public function andThen(Func $after): Func;
}
