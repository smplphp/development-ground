<?php

namespace Smpl\Functional\Contracts;

/**
 * @template P of mixed
 */
interface Comparable
{
    /**
     * Compares this implementation against a provided value
     *
     * Takes an argument B and compares it against the implementation to determine
     * whether it is less than, equal to, or greater than the provided value, returning
     * a value that is negative, zero, or positive, respectively.
     *
     * This method is an implementation of the mathematical sign, or signum function.
     *
     * If B is the same type as this implementation, then reversing the operation should
     * flip the result. If B compared to this is 10, then this compared to B should be
     * -10.
     *
     * The relation should also remain transitive for implementations of this contract that
     * are the same type. Assuming this class is A, if A is greater than B, and B is greater
     * than C, which is also of the same type, then A is also greater than C. Likewise,
     * if A is equal to B, and A compared to C is 3, then B compared to C must also be 3.
     *
     * @param P $b
     *
     * @return int
     *
     * @see \Smpl\Functional\Contracts\Comparator::compare()
     */
    public function compareTo(mixed $b): int;
}
