<?php
declare(strict_types=1);

namespace Smpl\Utilities;

use Smpl\Utilities\Contracts\Func;
use Smpl\Utilities\Contracts\Predicate;
use Smpl\Utilities\Predicates\CallablePredicate;
use Smpl\Utilities\Predicates\ComposedPredicate;
use Smpl\Utilities\Predicates\EqualToPredicate;
use Smpl\Utilities\Predicates\GreaterThanPredicate;
use Smpl\Utilities\Predicates\LessThanPredicate;
use Smpl\Utilities\Predicates\LogicalAndPredicate;
use Smpl\Utilities\Predicates\LogicalNotPredicate;
use Smpl\Utilities\Predicates\LogicalOrPredicate;
use Smpl\Utilities\Predicates\LogicalXorPredicate;
use Smpl\Utilities\Predicates\NotEqualToPredicate;

/**
 * Predicates Factory
 */
final class Predicates
{
    /**
     * Create a new predicate that wraps a callable
     *
     * Takes a callable and wraps it in an implementation of
     * {@see \Smpl\Utilities\Contracts\Predicate}.
     *
     * @template P of mixed
     *
     * @param callable(P):bool $callable
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * Takes a {@see \Smpl\Utilities\Contracts\Func} and a {@see \Smpl\Utilities\Contracts\Predicate
     * and returns a composed predicate where the function is run on the argument, and
     * its return value is tested with the predicate.
     *
     * @template P of mixed
     * @template T of mixed
     *
     * @param \Smpl\Utilities\Contracts\Func<P, T>    $before
     * @param \Smpl\Utilities\Contracts\Func<T, bool> $after
     *
     * @return \Smpl\Utilities\Contracts\Predicate<T>
     *
     * @psalm-return \Smpl\Utilities\Predicates\ComposedPredicate<P, T>
     *
     * @see \Smpl\Utilities\Contracts\Func::compose()
     * @see \Smpl\Utilities\Contracts\Predicate::compose()
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
     * @param \Smpl\Utilities\Contracts\Predicate<P> $first
     * @param \Smpl\Utilities\Contracts\Predicate<P> $second
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * @param \Smpl\Utilities\Contracts\Predicate<P> $first
     * @param \Smpl\Utilities\Contracts\Predicate<P> $second
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * @param \Smpl\Utilities\Contracts\Predicate<P> $first
     * @param \Smpl\Utilities\Contracts\Predicate<P> $second
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
     *
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * @return \Smpl\Utilities\Contracts\Predicate<P>
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
     * @return \Smpl\Utilities\Contracts\Predicate<int|float>
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
     * @return \Smpl\Utilities\Contracts\Predicate<int|float>
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
     * @return \Smpl\Utilities\Contracts\Predicate<int|float>
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
     * @return \Smpl\Utilities\Contracts\Predicate<int|float>
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
     * @return \Smpl\Utilities\Contracts\Predicate<int>
     *
     * @psalm-return \Smpl\Utilities\Predicates\ComposedPredicate<int, int>
     *
     * @see \Smpl\Utilities\Functions\ModuloFunc
     */
    public static function divisibleBy(int $divisor): Predicate
    {
        /** @psalm-suppress InvalidArgument */
        return self::compose(Functions::mod($divisor), self::equalTo(0));
    }
}
