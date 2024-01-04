<?php
declare(strict_types=1);

namespace Smpl\Functional\Support;

use Smpl\Functional\Contracts\Func;
use Smpl\Functional\Contracts\Predicate;
use Smpl\Functional\Predicates;

/**
 * Base Predicate
 *
 * This is a base class that can be used by all {@see \Smpl\Functional\Contracts\Predicate}
 * implementations to provide the base functionality, such as an implementation of
 * {@see \Smpl\Functional\Contracts\Func::apply()}.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Support\BaseFunc<P, bool>
 * @implements \Smpl\Functional\Contracts\Predicate<P>
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
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function and(Predicate $predicate): Predicate
    {
        return Predicates::and($this, $predicate);
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function or(Predicate $predicate): Predicate
    {
        return Predicates::or($this, $predicate);
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function xor(Predicate $predicate): Predicate
    {
        return Predicates::xor($this, $predicate);
    }

    /**
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public function negate(): Predicate
    {
        return Predicates::not($this);
    }

    /**
     * @template T of mixed
     *
     * @param \Smpl\Functional\Contracts\Func<T, P> $before
     *
     * @return \Smpl\Functional\Contracts\Predicate<T>
     */
    public function compose(Func $before): Predicate
    {
        return Predicates::compose($before, $this);
    }
}
