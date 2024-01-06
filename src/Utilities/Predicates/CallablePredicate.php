<?php
declare(strict_types=1);

namespace Smpl\Utilities\Predicates;

use Override;
use Smpl\Utilities\Support\BasePredicate;

/**
 * Callable Predicate
 *
 * Represents an implementation of {@see \Smpl\Utilities\Contracts\Predicate} that
 * wraps a user provided callable.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Utilities\Support\BasePredicate<P>
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
