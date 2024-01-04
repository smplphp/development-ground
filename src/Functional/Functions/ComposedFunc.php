<?php
declare(strict_types=1);

namespace Smpl\Functional\Functions;

use Override;
use Smpl\Functional\Contracts\Func;
use Smpl\Functional\Support\BaseFunc;

/**
 * Composed Function
 *
 * Represents a composition of two functions, where the return value from the first
 * is provided as the argument for the second.
 *
 * @template P of mixed
 * @template R of mixed
 * @template T of mixed
 *
 * @extends \Smpl\Functional\Support\BaseFunc<P, R>
 */
final class ComposedFunc extends BaseFunc
{
    /**
     * @var \Smpl\Functional\Contracts\Func<P, T>
     */
    private Func $before;

    /**
     * @var \Smpl\Functional\Contracts\Func<T, R>
     */
    private Func $after;

    /**
     * @param \Smpl\Functional\Contracts\Func<P, T> $before
     * @param \Smpl\Functional\Contracts\Func<T, R> $after
     */
    public function __construct(Func $before, Func $after)
    {
        $this->before = $before;
        $this->after  = $after;
    }

    /**
     * @param P $value
     *
     * @return R
     */
    #[Override]
    public function apply(mixed $value): mixed
    {
        return $this->after->apply($this->before->apply($value));
    }
}
