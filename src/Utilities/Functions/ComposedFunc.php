<?php
declare(strict_types=1);

namespace Smpl\Utilities\Functions;

use Override;
use Smpl\Utilities\Contracts\Func;
use Smpl\Utilities\Support\BaseFunc;

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
 * @extends \Smpl\Utilities\Support\BaseFunc<P, R>
 */
final class ComposedFunc extends BaseFunc
{
    /**
     * @var \Smpl\Utilities\Contracts\Func<P, T>
     */
    private Func $before;

    /**
     * @var \Smpl\Utilities\Contracts\Func<T, R>
     */
    private Func $after;

    /**
     * @param \Smpl\Utilities\Contracts\Func<P, T> $before
     * @param \Smpl\Utilities\Contracts\Func<T, R> $after
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
