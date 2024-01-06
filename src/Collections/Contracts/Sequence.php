<?php

namespace Smpl\Collections\Contracts;

use Smpl\Utilities\Contracts\Comparator;

/**
 * Sequence Contract
 *
 * This contract represents a specialised collection that stores elements in
 * a sequential list. Removing elements will also shift the indexes of subsequent
 * elements to the left ($index - 1), meaning indexes are always in the range of
 * <0, n-1> where n is the current element count.
 *
 * Sequences also have additional methods for inserting, removing and retrieving
 * elements by their index.
 *
 * @template V of mixed
 *
 * @extends \Smpl\Collections\Contracts\Collection<V>
 */
interface Sequence extends Collection
{
    /**
     * Forget an element at the provided position
     *
     * Takes an argument of int to act as an index, returning true if an element
     * exists at that position and was removed, and false otherwise. Provided
     * indexes should be within the range of <0, n-1>.
     *
     * Elements with an index within the range of <i+1, n-1> where i is the provided
     * index will have their indexes shifted left ($index - 1).
     *
     * This method is an alternative to {@see self::remove()} that allows finer control
     * over where in the sequence the element that should be removed is.
     *
     * @param int $index
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the range of <0, n>
     */
    public function forget(int $index): bool;

    /**
     * Get an element at the provided position
     *
     * Takes an argument of type int and attempts to retrieve an element at that index.
     *
     * Some implementations may allow for negative indexes to be provided, following the standard
     * process of wrapping around from the end. Implementations that do so should allow indexes
     * within the range of <-i, i> where i is n-1 and n is the current element count.
     *
     * @param int $index
     *
     * @return V|null
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the range of <0, n>
     */
    public function get(int $index): mixed;

    /**
     * Get the first index of the provided element
     *
     * Takes an argument of type V and returns its index if it is found within
     * this collection, or false if it is not. If the optional comparator is provided,
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
     * @param V                                               $element
     * @param \Smpl\Utilities\Contracts\Comparator<V, V>|null $comparator
     *
     * @return int|false
     */
    public function indexOf(mixed $element, ?Comparator $comparator = null): int|false;

    /**
     * Inserts an element at the provided position
     *
     * Takes in argument of type int to act as an index, and another of type V
     * which is the element to be inserted, returning true if inserted, and false
     * otherwise. Provided indexes should be within the range of <0, n>.
     *
     * Elements with an index within the range of <i, n-1> where i is the provided
     * index will have their indexes shifted right ($index + 1).
     *
     * Implementations of this method may impose additional rules on whether the
     * element can be inserted.
     *
     * Attempting to insert an element as index n where n is the current element
     * count should function as if {@see self::add()} were called instead.
     *
     * This method is an alternative to {@see self::add()} that allows finer control
     * over where in the sequence an element is inserted.
     *
     * @param int<0, max> $index
     * @param V           $element
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the range of <0, n>
     */
    public function insert(int $index, mixed $element): bool;

    /**
     * Inserts multiple elements at the provided position
     *
     * Takes in argument of type int to act as an index, and another of type iterable<V>
     * which is a collection of elements to be inserted, returning true if the collection
     * was modified, and false otherwise. Provided indexes should be within the range
     * of <0, n>.
     *
     * Elements with an index within the range of <i, n-1> where i is the provided
     * index will have their indexes shifted right ($index + 1) for each successful insertion.
     *
     * Implementations of this method may impose additional rules on whether the
     * element can be inserted.
     *
     * Attempting to insert elements as index n where n is the current element
     * count should function as if {@see self::addAll()} were called instead.
     *
     * This method is an alternative to {@see self::addAll()} that allows finer control
     * over where in the sequence the elements are inserted.
     *
     * Implementations of this method must be consistent with {@see self::insert()}.
     *
     * @param int<0, max> $index
     * @param iterable<V> $elements
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the range of <0, n>
     */
    public function insertAll(int $index, iterable $elements): bool;

    /**
     * Replaces an element at the provided position
     *
     * Takes in argument of type int to act as an index, and another of type V
     * which is the element to be inserted, returning true if inserted, and false
     * otherwise. Provided indexes should be within the range of <0, n-1>.
     *
     * The provided element will overwrite elements that exist at the provided index.
     *
     * Implementations of this method may impose additional rules on whether the
     * element can be inserted.
     *
     * This method is an alternative to {@see self::insert()} that replaces the element
     * rather than shift it.
     *
     * @param int<0, max> $index
     * @param V           $element
     *
     * @return bool
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the range of <0, n-1>
     */
    public function set(int $index, mixed $element): bool;

    /**
     * Sorts this collection using the provided comparator
     *
     * Takes an argument of type Comparator<V> and uses it to sort all elements contained
     * within this collection. While it is possible that the actual order of the elements
     * remains unchanged, it should be assumed that element indexes will have changed.
     *
     * @param \Smpl\Utilities\Contracts\Comparator<V, V> $comparator
     *
     * @return static
     */
    public function sort(Comparator $comparator): static;

    /**
     * Returns a new collection of elements that exist within the provided range
     *
     * Takes two arguments of type int with the first specifying the start of the range,
     * and the second specifying the number of elements. This method will then return a
     * new instance of this collection containing only the elements that exist within
     * the range of <i, i+c> where i is the index and c is the count.
     *
     * Some implementations may allow for a negative index to be provided, following the standard
     * process of wrapping around from the end. Implementations that do so should allow indexes
     * within the range of <-i, i> where i is n-1 and n is the current element count. Implementations
     * that allow this should also ensure that the provided count is within the range of
     * <1, n> where n is the current element count.
     *
     * @param int $index
     * @param int $count
     *
     * @return static
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the range of <0, n-1>
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided count is outside the range of <1, n>
     */
    public function slice(int $index, int $count): static;
}
