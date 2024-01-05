<?php
declare(strict_types=1);

namespace Smpl\Functional;

use Smpl\Functional\Contracts\Func;
use Smpl\Functional\Contracts\Predicate;
use Smpl\Functional\Predicates\CallablePredicate;
use Smpl\Functional\Predicates\ComposedPredicate;
use Smpl\Functional\Predicates\EqualToPredicate;
use Smpl\Functional\Predicates\GreaterThanPredicate;
use Smpl\Functional\Predicates\LessThanPredicate;
use Smpl\Functional\Predicates\LogicalAndPredicate;
use Smpl\Functional\Predicates\LogicalNotPredicate;
use Smpl\Functional\Predicates\LogicalOrPredicate;
use Smpl\Functional\Predicates\LogicalXorPredicate;
use Smpl\Functional\Predicates\NotEqualToPredicate;

/**
 * Predicates Factory
 */
final class Predicates
{
    /**
     * Create a new predicate that wraps a callable
     *
     * Takes a callable and wraps it in an implementation of
     * {@see \Smpl\Functional\Contracts\Predicate}.
     *
     * @template P of mixed
     *
     * @param callable(P):bool $callable
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function callable(callable $callable): Predicate
    {
        if ($callable instanceof Predicate) {
            return $callable;
        }

        return new CallablePredicate($callable);
    }

    /**
     * Create a new composed predicate
     *
     * Takes a {@see \Smpl\Functional\Contracts\Func} and a {@see \Smpl\Functional\Contracts\Predicate
     * and returns a composed predicate where the function is run on the argument, and
     * its return value is tested with the predicate.
     *
     * @template P of mixed
     * @template T of mixed
     *
     * @param \Smpl\Functional\Contracts\Func<P, T>    $before
     * @param \Smpl\Functional\Contracts\Func<T, bool> $after
     *
     * @return \Smpl\Functional\Contracts\Predicate<T>
     *
     * @psalm-return \Smpl\Functional\Predicates\ComposedPredicate<P, T>
     *
     * @see \Smpl\Functional\Contracts\Func::compose()
     * @see \Smpl\Functional\Contracts\Predicate::compose()
     */
    public static function compose(Func $before, Func $after): Predicate
    {
        return new ComposedPredicate($before, $after);
    }

    /**
     * Create a new logical AND predicate of two provided predicates
     *
     * Takes two predicates and returns a new one that represents a short-circuiting
     * logical AND of the two.
     *
     * @template P of mixed
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $first
     * @param \Smpl\Functional\Contracts\Predicate<P> $second
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function and(Predicate $first, Predicate $second): Predicate
    {
        return new LogicalAndPredicate($first, $second);
    }

    /**
     * Create a new logical OR predicate of two provided predicates
     *
     * Takes two predicates and returns a new one that represents a short-circuiting
     * logical OR of the two.
     *
     * @template P of mixed
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $first
     * @param \Smpl\Functional\Contracts\Predicate<P> $second
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function or(Predicate $first, Predicate $second): Predicate
    {
        return new LogicalOrPredicate($first, $second);
    }

    /**
     * Create a new logical XOR predicate of two provided predicates
     *
     * Takes two predicates and returns a new one that represents a logical XOR of the two.
     *
     * @template P of mixed
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $first
     * @param \Smpl\Functional\Contracts\Predicate<P> $second
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function xor(Predicate $first, Predicate $second): Predicate
    {
        return new LogicalXorPredicate($first, $second);
    }

    /**
     * Create a new logical NOT predicate of a provided predicate
     *
     * Takes a predicate and returns a new one that represents a logical NOT, or
     * negation of it.
     *
     * @template P of mixed
     *
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function not(Predicate $predicate): Predicate
    {
        return new LogicalNotPredicate($predicate);
    }

    /**
     * Create a new comparative equals predicate
     *
     * Takes a value and returns a predicate that compares against the provided
     * value using either the identical operator (===) or the equality operator (==)
     * depending on the value of strict.
     *
     * @template P of mixed
     *
     * @param P $subject
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function equalTo(mixed $subject, bool $strict = true): Predicate
    {
        return new EqualToPredicate($subject, $strict);
    }

    /**
     * Create a new comparative not equals predicate
     *
     * Takes a value and returns a predicate that compares against the provided
     * value using either the not identical operator (!==) or the not equal operator (!=)
     * depending on the value of strict.
     *
     * @template P of mixed
     *
     * @param P $subject
     *
     * @return \Smpl\Functional\Contracts\Predicate<P>
     */
    public static function notEqualTo(mixed $subject, bool $strict = true): Predicate
    {
        return new NotEqualToPredicate($subject, $strict);
    }

    /**
     * Create a new comparative less than predicate
     *
     * Takes a value and returns a predicate that compares against the provided
     * value to see a second provided value is less than it.
     *
     * @param int|float $subject
     *
     * @return \Smpl\Functional\Contracts\Predicate<int|float>
     */
    public static function lessThan(int|float $subject): Predicate
    {
        return new LessThanPredicate($subject);
    }

    /**
     * Create a new comparative greater than predicate
     *
     * Takes a value and returns a predicate that compares against the provided
     * value to see a second provided value is greater than it.
     *
     * @param int|float $subject
     *
     * @return \Smpl\Functional\Contracts\Predicate<int|float>
     */
    public static function greaterThan(int|float $subject): Predicate
    {
        return new GreaterThanPredicate($subject);
    }

    /**
     * Create a new comparative less than or equal to predicate
     *
     * Takes a value and returns a predicate that compares against the provided
     * value to see a second provided value is less than or equal to it.
     *
     * @param int|float $subject
     *
     * @return \Smpl\Functional\Contracts\Predicate<int|float>
     */
    public static function lessThanOrEqualTo(int|float $subject): Predicate
    {
        return self::or(self::lessThan($subject), self::equalTo($subject));
    }

    /**
     * Create a new comparative greater than or equal to predicate
     *
     * Takes a value and returns a predicate that compares against the provided
     * value to see a second provided value is greater than or equal to it.
     *
     * @param int|float $subject
     *
     * @return \Smpl\Functional\Contracts\Predicate<int|float>
     */
    public static function greaterThanOrEqualTo(int|float $subject): Predicate
    {
        return self::or(self::greaterThan($subject), self::equalTo($subject));
    }

    /**
     * Create a new divisible by predicate
     *
     * Takes a value and returns a predicate that checks if a second value is divisible
     * by the first. Performs a modulo operation and compares the returned valued with
     * 0.
     *
     * @param int $divisor
     *
     * @return \Smpl\Functional\Contracts\Predicate<int>
     *
     * @psalm-return \Smpl\Functional\Predicates\ComposedPredicate<int, int>
     *
     * @see \Smpl\Functional\Functions\ModuloFunc
     */
    public static function divisibleBy(int $divisor): Predicate
    {
        /** @psalm-suppress InvalidArgument */
        return self::compose(Functions::mod($divisor), self::equalTo(0));
    }
}
