<?php
declare(strict_types=1);

namespace Smpl\Utilities;

use Smpl\Utilities\Contracts\Func;
use Smpl\Utilities\Functions\CallableFunc;
use Smpl\Utilities\Functions\ComposedFunc;
use Smpl\Utilities\Functions\ModuloFunc;

/**
 * Functions Factory
 */
final class Functions
{
    /**
     * Create a new function that wraps a callable
     *
     * Takes a callable and wraps it in an implementation of
     * {@see \Smpl\Utilities\Contracts\Func}.
     *
     * @template P of mixed
     * @template R of mixed
     *
     * @param callable(P):R $callable
     *
     * @return \Smpl\Utilities\Contracts\Func<P, R>
     */
    public static function callable(callable $callable): Func
    {
        if ($callable instanceof Func) {
            return $callable;
        }

        return new CallableFunc($callable);
    }

    /**
     * Create a new composed function
     *
     * Takes two {@see \Smpl\Utilities\Contracts\Func} and returns a composed function
     * where the return value of the first is provided as the argument of the second.
     *
     * @template P of mixed
     * @template R of mixed
     * @template T of mixed
     *
     * @param \Smpl\Utilities\Contracts\Func<P, T> $before
     * @param \Smpl\Utilities\Contracts\Func<T, R> $after
     *
     * @return \Smpl\Utilities\Contracts\Func<P, R>
     *
     * @see \Smpl\Utilities\Contracts\Func::compose()
     */
    public static function compose(Func $before, Func $after): Func
    {
        return new ComposedFunc($before, $after);
    }

    /**
     * Create a new modulo function
     *
     * Takes a value and returns a new function that performs the modulo operation
     * with the value acting as a divisor and a second value provided during
     * function application acts as the dividend.
     *
     * @param int $divisor
     *
     * @return \Smpl\Utilities\Contracts\Func<int, int>
     */
    public static function mod(int $divisor): Func
    {
        return new ModuloFunc($divisor);
    }
}
