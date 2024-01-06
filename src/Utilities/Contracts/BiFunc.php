<?php

namespace Smpl\Utilities\Contracts;

/**
 * Binary Function Contract
 *
 * This contract is at the core of the functional utility library, and represents
 * a simple function that takes two arguments and can be applied to value.
 *
 * @template P1 of mixed
 * @template P2 of mixed
 * @template R of mixed
 */
interface BiFunc
{
    /**
     * Apply this function to the provided values
     *
     * Takes two arguments of type P1 and P2 and returns a value of type R.
     *
     * @param P1 $value1
     * @param P2 $value2
     *
     * @return R
     */
    public function apply(mixed $value1, mixed $value2): mixed;
}
