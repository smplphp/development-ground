<?php
declare(strict_types=1);

namespace Smpl\Functional\Predicates;

use Override;
use Smpl\Functional\Contracts\Func;
use Smpl\Functional\Contracts\Predicate;
use Smpl\Functional\Support\BasePredicate;

/**
 * Composed Predicate
 *
 * Represents a composition of two functions, where the return value from the first
 * is provided as the argument for the second, and the second returns a boolean.
 *
 * In most cases the after, or second function, will be a {@see \Smpl\Functional\Contracts\Predicate}
 * implementation.
 *
 * @template P of mixed
 * @template T of mixed
 *
 * @extends \Smpl\Functional\Support\BasePredicate<P>
 */
final class ComposedPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Functional\Contracts\Func<P, T>
     */
    private Func $before;

    /**
     * @var \Smpl\Functional\Contracts\Func<T, bool>
     */
    private Func $after;

    /**
     * @param \Smpl\Functional\Contracts\Func<P, T> $before
     * @param \Smpl\Functional\Contracts\Func<T, bool> $after
     */
    public function __construct(Func $before, Func $after)
    {
        $this->before = $before;
        $this->after  = $after;
    }

    /**
     * @param P $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $this->after->apply($this->before->apply($value));
    }
}
