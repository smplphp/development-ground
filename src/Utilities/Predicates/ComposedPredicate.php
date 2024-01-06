<?php
declare(strict_types=1);

namespace Smpl\Utilities\Predicates;

use Override;
use Smpl\Utilities\Contracts\Func;
use Smpl\Utilities\Contracts\Predicate;
use Smpl\Utilities\Support\BasePredicate;

/**
 * Composed Predicate
 *
 * Represents a composition of two functions, where the return value from the first
 * is provided as the argument for the second, and the second returns a boolean.
 *
 * In most cases the after, or second function, will be a {@see \Smpl\Utilities\Contracts\Predicate}
 * implementation.
 *
 * @template P of mixed
 * @template T of mixed
 *
 * @extends \Smpl\Utilities\Support\BasePredicate<P>
 */
final class ComposedPredicate extends BasePredicate
{
    /**
     * @var \Smpl\Utilities\Contracts\Func<P, T>
     */
    private Func $before;

    /**
     * @var \Smpl\Utilities\Contracts\Func<T, bool>
     */
    private Func $after;

    /**
     * @param \Smpl\Utilities\Contracts\Func<P, T>    $before
     * @param \Smpl\Utilities\Contracts\Func<T, bool> $after
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
