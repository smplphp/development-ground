<?php
declare(strict_types=1);

namespace Smpl\Utilities\Support;

use Smpl\Utilities\Contracts\Func;
use Smpl\Utilities\Contracts\Predicate;
use Smpl\Utilities\Predicates;

/**
 * Base Predicate
 *
 * This is a base class that can be used by all {@see \Smpl\Utilities\Contracts\Predicate}
 * implementations to provide the base functionality, such as an implementation of
 * {@see \Smpl\Utilities\Contracts\Func::apply()}.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Utilities\Support\BaseFunc<P, bool>
 * @implements \Smpl\Utilities\Contracts\Predicate<P>
 */
abstract class BasePredicate extends BaseFunc implements Predicate
{
    /**
     * @param P $value
     *
     * @return bool
     */
    public function apply(mixed $value): bool
    {
        return $this->test($value);
    }

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
     */
    public function and(Predicate $predicate): Predicate
    {
        return Predicates::and($this, $predicate);
    }

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
     */
    public function or(Predicate $predicate): Predicate
    {
        return Predicates::or($this, $predicate);
    }

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
     */
    public function xor(Predicate $predicate): Predicate
    {
        return Predicates::xor($this, $predicate);
    }

    /**
     * @return \Smpl\Utilities\Contracts\Predicate<P>
     */
    public function negate(): Predicate
    {
        return Predicates::not($this);
    }

    /**
     * @template T of mixed
     *
     * @param \Smpl\Utilities\Contracts\Func<T, P> $before
     *
     * @return \Smpl\Utilities\Contracts\Predicate<T>
     */
    public function compose(Func $before): Predicate
    {
        return Predicates::compose($before, $this);
    }
}
