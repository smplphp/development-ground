<?php
declare(strict_types=1);

namespace Smpl\Functional\Predicates;

use Override;
use Smpl\Functional\Contracts\Predicate;
use Smpl\Functional\Support\BasePredicate;

/**
 * Logical Or Predicate
 *
 * Represents a short-circuiting logical OR of two predicates.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Support\BasePredicate<P>
 */
final class LogicalOrPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Functional\Contracts\Predicate<P>
     */
    private Predicate $first;

    /**
     * @var \Smpl\Functional\Contracts\Predicate<P>
     */
    private Predicate $second;

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $first
     * @param \Smpl\Functional\Contracts\Predicate<P> $second
     */
    public function __construct(Predicate $first, Predicate $second)
    {
        $this->first = $first;
        $this->second = $second;
    }

    /**
     * @param P $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        if ($this->first->test($value)) {
            return true;
        }

        return $this->second->test($value);
    }
}
