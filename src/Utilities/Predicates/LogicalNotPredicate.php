<?php
declare(strict_types=1);

namespace Smpl\Utilities\Predicates;

use Override;
use Smpl\Utilities\Contracts\Predicate;
use Smpl\Utilities\Support\BasePredicate;

/**
 * Logical Not Predicate
 *
 * Represents a logical NOT/negation of a predicate.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Utilities\Support\BasePredicate<P>
 */
final class LogicalNotPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Utilities\Contracts\Predicate<P>
     */
    private Predicate $predicate;

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
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
