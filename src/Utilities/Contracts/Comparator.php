<?php

namespace Smpl\Utilities\Contracts;


/**
 * Comparator Contract
 *
 * This contract represents an operation that compares two values to determine
 * their difference. Comparators are designed to be used as both a way of enforcing
 * an order on a collection of values, and determining their difference for
 * any other arbitrary purpose.
 *
 * Implementations of this contract should state whether equality is determined
 * in the technically correct way of using PHPs equality operator (==), or the
 * best practice of using the identicality operator (===).
 *
 * @template P1 of mixed
 * @template P2 of mixed
 *
 * @phpstan-pure
 * @psalm-pure
 */
interface Comparator
{
    /**
     * Compare two values to determine their comparative difference
     *
     * Takes two arguments, A and B, and compares them to determine whether A is less than,
     * equal to, or greater than B, returning a value that is negative, zero, or positive,
     * respectively.
     *
     * This method is an implementation of the mathematical sign, or signum function.
     *
     * Implementations must ensure flipping the arguments also flips the result. If A compared
     * to B is -10, then B compared to A would be 10.
     *
     * Implementations must also ensure that the relation is transitive, so if A is greater than
     * B, and B is greater than C, A is also greater than C. Likewise, if A is equal to B, and A
     * compared to C is 3, then B compared to C must also be 3.
     *
     * @param P1 $a
     * @param P2 $b
     *
     * @return int
     *
     * @psalm-mutation-free
     */
    public function compare(mixed $a, mixed $b): int;

    /**
     * Determine whether A is less than B
     *
     * Takes two arguments, A and B, and compares them to determine whether A is less
     * than B, returning a boolean.
     *
     * This method is designed as a helper, and it is recommended that any implementation
     * simply check {@see self::compare()} for the return value being negative.
     *
     * @param P1 $a
     * @param P2 $b
     *
     * @return bool
     *
     * @psalm-mutation-free
     */
    public function isLessThan(mixed $a, mixed $b): bool;

    /**
     * Determine whether A is greater than B
     *
     * Takes two arguments, A and B, and compares them to determine whether A is greater
     * than B, returning a boolean.
     *
     * This method is designed as a helper, and it is recommended that any implementation
     * simply check {@see self::compare()} for the return value being positive.
     *
     * @param P1 $a
     * @param P2 $b
     *
     * @return bool
     *
     * @psalm-mutation-free
     */
    public function isGreaterThan(mixed $a, mixed $b): bool;

    /**
     * Determine whether A is equal to B
     *
     * Takes two arguments, A and B, and compares them to determine whether A is equal
     * to B, returning a boolean.
     *
     * This method is designed as a helper, and it is recommended that any implementation
     * simply check {@see self::compare()} for the return value being zero.
     *
     * @param P1 $a
     * @param P2 $b
     *
     * @return bool
     *
     * @psalm-mutation-free
     */
    public function isEqualTo(mixed $a, mixed $b): bool;
}
