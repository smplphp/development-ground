<?php

namespace Smpl\Utilities\Contracts;

/**
 * Binary Predicate Contract
 *
 * This contract represents a boolean-valued function, often called a 'predicate', that
 * tests two given values and returns a boolean.
 *
 * @template P1 of mixed
 * @template P2 of mixed
 *
 * @extends \Smpl\Utilities\Contracts\BiFunc<P1, P2, bool>
 */
interface BiPredicate extends BiFunc
{
    /**
     * Tests the provided value against this predicate
     *
     * Takes an argument of type P and tests to return a bool.
     *
     * @param P1 $value1
     * @param P2 $value2
     *
     * @return bool
     */
    public function test(mixed $value1, mixed $value2): bool;

    /**
     * Create a logical AND predicate of this and another
     *
     * Takes an argument of type {@see \Smpl\Utilities\Contracts\BiPredicate} and returns
     * a new {@see \Smpl\Utilities\Contracts\BiPredicate} that represents a short-circuiting
     * logical AND of this predicate and the provided.
     *
     * @param \Smpl\Utilities\Contracts\BiPredicate<P1, P2> $predicate
     *
     * @return \Smpl\Utilities\Contracts\BiPredicate<P1, P2>
     */
    public function and(BiPredicate $predicate): BiPredicate;

    /**
     * Create a logical OR predicate of this and another
     *
     * Takes an argument of type {@see \Smpl\Utilities\Contracts\BiPredicate} and returns
     * a new {@see \Smpl\Utilities\Contracts\BiPredicate} that represents a short-circuiting
     * logical OR of this predicate and the provided.
     *
     * @param \Smpl\Utilities\Contracts\BiPredicate<P1, P2> $predicate
     *
     * @return \Smpl\Utilities\Contracts\BiPredicate<P1, P2>
     */
    public function or(BiPredicate $predicate): BiPredicate;

    /**
     * Create a logical XOR predicate of this and another
     *
     * Takes an argument of type {@see \Smpl\Utilities\Contracts\BiPredicate} and returns
     * a new {@see \Smpl\Utilities\Contracts\BiPredicate} that represents a logical XOR of
     * this predicate and the provided.
     *
     * @param \Smpl\Utilities\Contracts\BiPredicate<P1, P2> $predicate
     *
     * @return \Smpl\Utilities\Contracts\BiPredicate<P1, P2>
     */
    public function xor(BiPredicate $predicate): BiPredicate;

    /**
     * Create a logical NOT predicate of this
     *
     * Takes no arguments and returns a new {@see \Smpl\Utilities\Contracts\BiPredicate} that
     * represents a logical NOT/negation of this predicate.
     *
     * @return \Smpl\Utilities\Contracts\BiPredicate<P1, P2>
     */
    public function negate(): BiPredicate;
}
