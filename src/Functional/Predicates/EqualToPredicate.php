<?php
declare(strict_types=1);

namespace Smpl\Functional\Predicates;

use Override;
use Smpl\Functional\Contracts\Predicate;
use Smpl\Functional\Support\BasePredicate;

/**
 * Equal to Predicate
 *
 * Represents the comparison of two values for equality.
 *
 * Due to the ambiguity with the term "equals" and PHPs comparison operators,
 * this predicate provides a strict and non-strict mode, where strict will
 * check that the values are identical (===), and non-strict checks if they
 * equal (==).
 *
 * Strict comparison is the default.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Support\BasePredicate<P>
 */
final class EqualToPredicate extends BasePredicate
{
    /**
     * @var P
     */
    private mixed $subject;

    private bool $strict;

    /**
     * @param P $subject
     */
    public function __construct(mixed $subject, bool $strict = true)
    {
        $this->subject = $subject;
        $this->strict  = $strict;
    }

    /**
     * @param P $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        if ($this->strict) {
            return $value === $this->subject;
        }

        /**
         * This is intentionally using the equality operator, please do not
         * panic.
         *
         * @noinspection TypeUnsafeComparisonInspection
         */
        return $value == $this->subject;
    }

    /**
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function negate(): Predicate
    {
        return new NotEqualToPredicate($this->subject);
    }
}
