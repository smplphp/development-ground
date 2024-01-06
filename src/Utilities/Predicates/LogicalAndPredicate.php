<?php
declare(strict_types=1);

namespace Smpl\Utilities\Predicates;

use Override;
use Smpl\Utilities\Contracts\Predicate;
use Smpl\Utilities\Support\BasePredicate;

/**
 * Logical And Predicate
 *
 * Represents a short-circuiting logical AND of two predicates.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Utilities\Support\BasePredicate<P>
 */
final class LogicalAndPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Utilities\Contracts\Predicate<P>
     */
    private Predicate $first;

    /**
     * @var \Smpl\Utilities\Contracts\Predicate<P>
     */
    private Predicate $second;

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $first
     * @param \Smpl\Utilities\Contracts\Predicate<P> $second
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
            return $this->second->test($value);
        }

        return false;
    }
}
