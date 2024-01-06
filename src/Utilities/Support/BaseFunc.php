<?php
declare(strict_types=1);

namespace Smpl\Utilities\Support;

use Smpl\Utilities\Contracts\Func;
use Smpl\Utilities\Functions;

/**
 * Base Function
 *
 * This is a base class that can be used by all {@see \Smpl\Utilities\Contracts\Func}
 * implementations to provide the base functionality, such as the magic __invoke method.
 *
 * @template P of mixed
 * @template R of mixed
 *
 * @implements \Smpl\Utilities\Contracts\Func<P, R>
 */
abstract class BaseFunc implements Func
{
    /**
     * Invoke
     *
     * Invokes the {@see \Smpl\Utilities\Contracts\Func::apply()} method.
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
     * @param \Smpl\Utilities\Contracts\Func<T, P> $before
     *
     * @return \Smpl\Utilities\Contracts\Func<T, R>
     */
    public function compose(Func $before): Func
    {
        return Functions::compose($before, $this);
    }

    /**
     * @template T of mixed
     *
     * @param \Smpl\Utilities\Contracts\Func<R, T> $after
     *
     * @return \Smpl\Utilities\Contracts\Func<P, T>
     */
    public function andThen(Func $after): Func
    {
        return Functions::compose($this, $after);
    }
}
