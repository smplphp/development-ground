<?php

namespace Smpl\Functional\Contracts;

/**
 * Supplier Contract
 *
 * This contract represents a function that supplies a value of a specific type.
 *
 * This contract is not compatible with {@see \Smpl\Functional\Contracts\Func} due
 * to it requiring no parameters.
 *
 * @template R of mixed
 */
interface Supplier
{
    /**
     * Get a value
     *
     * Takes no arguments and returns a value of type R. There is no requirement
     * that this supplier should return a new or distinct result each time this
     * method is called.
     *
     * @return R
     */
    public function get(): mixed;
}
