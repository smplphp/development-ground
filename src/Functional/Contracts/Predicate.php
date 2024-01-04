<?php

namespace Smpl\Functional\Contracts;

/**
 * Predicate Contract
 *
 * This contract represents a boolean-valued function, often called a 'predicate', that
 * tests a given value and returns a boolean.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Contracts\Func<P, bool>
 *
 * @method Predicate compose(Func $before)
 */
interface Predicate extends Func
{
    /**
     * Tests the provided value against this predicate
     *
     * Takes an argument of type P and tests to return a bool.
     *
     * @param P $value
     *
     * @return bool
     */
    public function test(mixed $value): bool;

    /**
     * Create a logical AND predicate of this and another
     *
     * Takes an argument of type {@see \Smpl\Functional\Contracts\Predicate}<P> and returns
     * a new {@see \Smpl\Functional\Contracts\Predicate} that represents a short-circuiting
     * logical AND of this predicate and the provided.
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function and(Predicate $predicate): Predicate;

    /**
     * Create a logical OR predicate of this and another
     *
     * Takes an argument of type {@see \Smpl\Functional\Contracts\Predicate}<P> and returns
     * a new {@see \Smpl\Functional\Contracts\Predicate} that represents a short-circuiting
     * logical OR of this predicate and the provided.
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function or(Predicate $predicate): Predicate;

    /**
     * Create a logical XOR predicate of this and another
     *
     * Takes an argument of type {@see \Smpl\Functional\Contracts\Predicate}<P> and returns
     * a new {@see \Smpl\Functional\Contracts\Predicate} that represents a logical XOR of
     * this predicate and the provided.
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function xor(Predicate $predicate): Predicate;

    /**
     * Create a logical NOT predicate of this
     *
     * Takes no arguments and returns a new {@see \Smpl\Functional\Contracts\Predicate} that
     * represents a logical NOT/negation of this predicate.
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function negate(): Predicate;
}
