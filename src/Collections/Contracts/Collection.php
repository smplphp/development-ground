<?php

namespace Smpl\Collections\Contracts;

use Smpl\Functional\Contracts\Comparator;
use Smpl\Functional\Contracts\Predicate;

/**
 * Collection Contract
 *
 * This contract represents the base of the list-based collections. Implementations
 * of this contract deal specifically with the elements of the collection.
 *
 * The keying of elements within the collection is dependent entirely on the
 * implementation.
 *
 * All methods that accept a combination of element(s) and comparator should behave
 * consistently given the same combination. For example, if {@see self::contains()}
 * returns true, then {@see self::remove()} should also return true for the same
 * combination.
 *
 * Some methods that accept a single element have a paired method that accepts multiple,
 * typically with the same name suffixed with 'All'. The behaviour of these methods should be
 * consistent. For example, if {@see self::containsAll()} returns true for a collection A, B and C,
 * then the result of three successive calls to {@see self::contains()} with A, B and C, piped
 * together with a logical AND, should also have the same result. Behaviour should be consistent
 * when including comparators.
 *
 * @template V of mixed
 *
 * @extends \Smpl\Collections\Contracts\Enumerable<int, V>
 *
 * @internal This contract should not be implemented directly
 */
interface Collection extends Enumerable
{
    /**
     * Add an element to this collection
     *
     * Takes an argument of type V and adds it to this collection, returning true
     * if it was successful, and false otherwise.
     *
     * The location of the new element within this collection is an
     * implementation-specific detail, along with how it is determined whether
     * an element can be added.
     *
     * @param V $element
     *
     * @return bool
     */
    public function add(mixed $element): bool;

    /**
     * Add all elements to this collection
     *
     * Takes an argument of type iterable<V> and adds all elements within it to this
     * collection, returning true if the collection was modified, and false otherwise.
     *
     * Returning true does not mean that all elements were added, just that at least
     * one was. The location of these new elements is an implementation-specific
     * detail, along with how it is determined whether an element can be added.
     *
     * Implementations of this method must be consistent with {@see self::add()}.
     *
     * @param iterable<V> $elements
     *
     * @return bool
     *
     * @see \Smpl\Collections\Contracts\Collection::add()
     */
    public function addAll(iterable $elements): bool;

    /**
     * Clear this collection of all elements
     *
     * Returns this collection with all the elements removed. Unless otherwise specified,
     * it can be assumed that this method modifies the collection inline.
     *
     * Implementations of this method should be consistent with the behaviour of
     * {@see self::remove()}, such that the resulting collection and any side effects
     * are the same as if {@see self::remove()} were called with each element in turn.
     *
     * @return static
     */
    public function clear(): static;

    /**
     * Determine whether the provided value is contained within this collection
     *
     * Takes an argument of type V and returns true if it is found within
     * this collection, and false otherwise. If the optional comparator is provided,
     * it should be used to determine the presence within the collection.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of element and comparator given the same combination.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param V                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function contains(mixed $element, ?Comparator $comparator = null): bool;

    /**
     * Determine whether this collection contains all provided elements
     *
     * Takes an argument of type iterable<V> and returns true if all elements within it
     * are included within this collection, and false otherwise. If the optional comparator
     * is provided, it should be used to determine an elements' presence within the collection.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of element and comparator given the same combination.
     *
     * Implementations of this method should also be consistent with {@see self::contains()}.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param iterable<V>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function containsAll(iterable $elements, ?Comparator $comparator = null): bool;

    /**
     * Create and return an exact copy of this collection
     *
     * Returns a copy of this collection, identical in every way, with the exception that
     * it is a separate instance.
     *
     * Collections created by this method should be of the same type, contain the same
     * elements, and anything else required by the final implementation.
     *
     * @return static
     */
    public function copy(): static;

    /**
     * Checks if the collection is empty
     *
     * Returns true if this collection contains no elements, false otherwise.
     *
     * Behaviour of this method should be consistent with {@see self::count()} such
     * that if this method returns true, {@see self::count()} should return 0.
     *
     * While not required, it is recommended that any methods that require elements
     * within the collection short-circuit through usage of this method. For example,
     * it is preferable if all calls to {@see self::contains()} or {@see self::containsAll()}
     * return false if this method returns true, without ever performing the actual check.
     *
     * Implementations of this method should be consistent with {@see self::isNotEmpty()}.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Checks if the collection is not empty
     *
     * Returns true if this collection contains elements, false otherwise.
     *
     * Behaviour of this method should be consistent with {@see self::count()} such
     * that if this method returns true, {@see self::count()} should return a positive number.
     *
     * Implementations of this method should be consistent with {@see self::isEmpty()}.
     *
     * @return bool
     */
    public function isNotEmpty(): bool;

    /**
     * Remove an element from this collection
     *
     * Takes an argument of type V and removes the first instance of it from the collection,
     * returning true if an element was removed, and false otherwise. If the optional
     * comparator is provided, it should be used to determine the element to be removed.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of element and comparator given the same combination.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param V                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function remove(mixed $element, ?Comparator $comparator = null): bool;

    /**
     * Removes all elements from this collection that are in the provided elements
     *
     * Takes an argument of type iterable<V> and removes all elements present in both sets,
     * returning true if one or more elements were removed, and false if none were. If the
     * optional comparator is provided, it should be used to determine the element to be
     * removed.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of element and comparator given the same combination.
     *
     * Implementations of this method should be consistent with {@see self::remove()}.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param iterable<V>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function removeAll(iterable $elements, ?Comparator $comparator = null): bool;

    /**
     * Remove all elements from this collection that satisfy the provided predicate
     *
     * Takes an argument of type Predicate<V> and removes all elements present in this collection
     * that satisfy the predicate, returning true if one or more were removed, and false if none
     * were.
     *
     * Implementations of this method should be consistent with {@see self::removeAll()} as if
     * it was called with a collection of the same elements that satisfy the provided predicate.
     *
     * @param \Smpl\Functional\Contracts\Predicate<V> $predicate
     *
     * @return bool
     */
    public function removeIf(Predicate $predicate): bool;

    /**
     * Retain all elements in this collection that exist in the provided
     *
     * Takes an argument of type iterable and removes all elements from this collection that are
     * not present in the provided, returning true if any were removed and false if none were. If
     * the optional comparator is provided, it should be used to determine the element to be
     * removed.
     *
     * If no elements in this collection are present in the provided, this collection will be
     * left empty as if {@see self::clear()} were used. This method should not add any elements
     * that are present in the provided, but not this collection.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of element and comparator given the same combination.
     *
     * @param iterable<V>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function retainAll(iterable $elements, ?Comparator $comparator = null): bool;

    /**
     * Retain all elements in this collection that satisfy the provided predicate
     *
     * Takes an argument of type Predicate<V> and removes all elements present in this collection
     * that do not satisfy the predicate, returning true if one or more were removed, and false if none
     * were.
     *
     * Implementations of this method should be consistent with {@see self::retainAll()} as if
     * it was called with a collection of the same elements that satisfy the provided predicate.
     *
     * Implementations of this method should also be consistent with {@see self::removeIf()},
     * representing the inverse operation.
     *
     * @param \Smpl\Functional\Contracts\Predicate<V> $predicate
     *
     * @return bool
     */
    public function retainIf(Predicate $predicate): bool;
}
