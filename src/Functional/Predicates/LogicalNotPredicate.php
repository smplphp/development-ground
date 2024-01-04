<?php
declare(strict_types=1);

namespace Smpl\Functional\Predicates;

use Override;
use Smpl\Functional\Contracts\Predicate;
use Smpl\Functional\Support\BasePredicate;

/**
 * Logical Not Predicate
 *
 * Represents a logical NOT/negation of a predicate.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Support\BasePredicate<P>
 */
final class LogicalNotPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Functional\Contracts\Predicate<P>
     */
    private Predicate $predicate;

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     */
    public function __construct(Predicate $predicate)
    {
        $this->predicate = $predicate;
    }

    /**
     * @param P $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return ! $this->predicate->test($value);
    }
}
