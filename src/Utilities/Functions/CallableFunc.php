<?php
declare(strict_types=1);

namespace Smpl\Utilities\Functions;

use Override;
use Smpl\Utilities\Support\BaseFunc;

/**
 * Callable Function
 *
 * Represents an implementation of {@see \Smpl\Utilities\Contracts\Func} that
 * wraps a user provided callable.
 *
 * @template P of mixed
 * @template R of mixed
 *
 * @extends \Smpl\Utilities\Support\BaseFunc<P, R>
 */
final class CallableFunc extends BaseFunc
{
    /**
     * @var callable(P):R
     */
    private $callable;

    /**
     * @param callable(P):R $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param P $value
     *
     * @return R
     */
    #[Override]
    public function apply(mixed $value): mixed
    {
        return call_user_func($this->callable, $value);
    }
}
