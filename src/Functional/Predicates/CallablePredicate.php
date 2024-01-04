<?php
declare(strict_types=1);

namespace Smpl\Functional\Predicates;

use Override;
use Smpl\Functional\Support\BasePredicate;

/**
 * Callable Predicate
 *
 * Represents an implementation of {@see \Smpl\Functional\Contracts\Predicate} that
 * wraps a user provided callable.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Support\BasePredicate<P>
 */
final class CallablePredicate extends BasePredicate
{
    /**
     * @var callable(P):bool
     */
    private $callable;

    /**
     * @param callable(P):bool $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param P $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return call_user_func($this->callable, $value);
    }
}
