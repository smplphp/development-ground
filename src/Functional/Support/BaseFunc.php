<?php
declare(strict_types=1);

namespace Smpl\Functional\Support;

use Smpl\Functional\Contracts\Func;
use Smpl\Functional\Functions\ComposedFunc;

/**
 * Base Func
 *
 * This is a base class that can be used by all {@see \Smpl\Functional\Contracts\Func}
 * implementations to provide the base functionality, such as the magic __invoke method.
 *
 * @template P of mixed
 * @template R of mixed
 *
 * @implements \Smpl\Functional\Contracts\Func<P, R>
 */
abstract class BaseFunc implements Func
{
    /**
     * Invoke
     *
     * Invokes the {@see \Smpl\Functional\Contracts\Func::apply()} method.
     *
     * @param P $value
     *
     * @return R
     */
    public function __invoke(mixed $value): mixed
    {
        return $this->apply($value);
    }

    /**
     * @template T of mixed
     *
     * @param \Smpl\Functional\Contracts\Func<T, P> $before
     *
     * @return \Smpl\Functional\Contracts\Func<T, R>
     */
    public function compose(Func $before): Func
    {
        return new ComposedFunc($before, $this);
    }
}
