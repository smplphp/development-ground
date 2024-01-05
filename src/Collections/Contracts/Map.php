<?php

namespace Smpl\Collections\Contracts;

use Smpl\Functional\Contracts\Comparator;
use Smpl\Functional\Contracts\Predicate;

/**
 * Map Contract
 *
 * This contract represents a map, a special type of collection that deals
 * with key => value pairs.
 *
 * Maps are similar to PHPs default array structures, except that maps allow
 * you to use keys that arrays otherwise wouldn't allow, such as objects.
 *
 * @template K of mixed
 * @template V of mixed
 *
 * @extends \Smpl\Collections\Contracts\Enumerable<K, V>
 */
interface Map extends Enumerable
{
    /**
     * Clear this map of all items
     *
     * Returns this map with all the items removed. Unless otherwise specified,
     * it can be assumed that this method modifies the map inline.
     *
     * Implementations of this method should be consistent with the behaviour of
     * {@see self::remove()}, such that the resulting map and any side effects
     * are the same as if {@see self::remove()} were called with each key in turn.
     *
     * @return static
     */
    public function clear(): static;

    /**
     * Determine whether the provided value is contained within this map
     *
     * Takes an argument of type V and returns true if it is found within
     * this map, and false otherwise. If the optional comparator is provided,
     * it should be used to determine the presence within the map.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of value and comparator given the same combination.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param V                                                $value
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function contains(mixed $value, ?Comparator $comparator = null): bool;

    /**
     * Determine whether this map contains all provided values
     *
     * Takes an argument of type iterable<V> and returns true if all values within it
     * are included within this map, and false otherwise. If the optional comparator
     * is provided, it should be used to determine a values' presence within the map.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of value and comparator given the same combination.
     *
     * Implementations of this method should also be consistent with {@see self::contains()}.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param iterable<V>                                      $values
     * @param \Smpl\Functional\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    public function containsAll(iterable $values, ?Comparator $comparator = null): bool;

    /**
     * Create and return an exact copy of this map
     *
     * Returns a copy of this map, identical in every way, with the exception that
     * it is a separate instance.
     *
     * Maps created by this method should be of the same type, contain the same
     * values, and anything else required by the final implementation.
     *
     * @return static
     */
    public function copy(): static;

    /**
     * Get a value for the provided key
     *
     * Takes an argument of type K and attempts to retrieve the value associated with that key,
     * if there is one.
     *
     * Some implementations may allow for negative indexes to be provided, following the standard
     * process of wrapping around from the end. Implementations that do so should allow indexes
     * within the range of <-i, i> where i is n-1 and n is the current value count.
     *
     * @param K $key
     *
     * @return V|null
     */
    public function get(mixed $key): mixed;

    /**
     * Determine whether the provided key is present in this map
     *
     * Takes an argument of type K and returns true if a value is mapped to it within
     * this map, and false otherwise. If the optional comparator is provided, it should
     * be used to determine the presence within the map.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of key and comparator given the same combination.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param K                                                $key
     * @param \Smpl\Functional\Contracts\Comparator<K, K>|null $comparator
     *
     * @return bool
     */
    public function has(mixed $key, ?Comparator $comparator = null): bool;

    /**
     * Determine whether this map contains all provided keys
     *
     * Takes an argument of type iterable<K> and returns true if all keys within it
     * are included within this map, and false otherwise. If the optional comparator
     * is provided, it should be used to determine a keys' presence within the map.
     *
     * It is recommended that implementations of this method short-circuit through the usage
     * of {@see self::isEmpty()}.
     *
     * Implementations of this method should be consistent with all methods that accept
     * a combination of key and comparator given the same combination.
     *
     * Implementations of this method should also be consistent with {@see self::has()}.
     *
     * The behaviour without a comparator is an implementation-specific detail.
     *
     * @param iterable<K> $keys
     *
     * @return bool
     */
    public function hasAll(iterable $keys): bool;

    /**
     * Checks if the map is empty
     *
     * Returns true if this map contains no values, false otherwise.
     *
     * Behaviour of this method should be consistent with {@see self::count()} such
     * that if this method returns true, {@see self::count()} should return 0.
     *
     * While not required, it is recommended that any methods that require values
     * within the map short-circuit through usage of this method. For example,
     * it is preferable if all calls to {@see self::contains()} or {@see self::containsAll()}
     * return false if this method returns true, without ever performing the actual check.
     *
     * Implementations of this method should be consistent with {@see self::isNotEmpty()}.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Checks if the map is not empty
     *
     * Returns true if this map contains values, false otherwise.
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
     * Get a collection of the keys from this map
     *
     * Returns a {@see \Smpl\Collections\Contracts\Set} containing all keys currently
     * present in this map.
     *
     * @return \Smpl\Collections\Contracts\Set<K>
     */
    public function keys(): Set;

    /**
     * Get a collection of the key value mappings from this map
     *
     * Returns a {@see \Smpl\Collections\Contracts\Collection} containing all the key
     * value mappings currently present in this map.
     *
     * @return \Smpl\Collections\Contracts\Collection<\Smpl\Collections\Contracts\Pair<K, V>>
     */
    public function pairs(): Collection;

    /**
     * Associate the provided value with the provided key in this map
     *
     * Takes an argument of type K and an argument of type V and associate them
     * within this map.
     *
     * Implementations of this method may have additional constraints over whether
     * a particular pair can be added, in which case they should throw an
     * appropriate exception.
     *
     * @param K $key
     * @param V $value
     */
    public function put(mixed $key, mixed $value): static;

    /**
     * Associate all key => value pairs provided in this map
     *
     * Takes an argument of type iterable<K, V> and associate them within this map.
     *
     * Implementations of this method should be consistent with {@see self::put()}.
     *
     * @param iterable<K, V> $map
     *
     * @return static
     */
    public function putAll(iterable $map): static;

    /**
     * Associate the provided value with the provided key in this map if the provided
     * predicate is satisfied
     *
     * Takes an argument of type K and an argument of type V and associate them
     * within this map if the provided predicate is satisfied
     *
     * Implementations of this method may have additional constraints over whether
     * a particular pair can be added, in which case they should throw an
     * appropriate exception.
     *
     * @param K                                                                           $key
     * @param V                                                                           $value
     * @param \Smpl\Functional\Contracts\Predicate<\Smpl\Collections\Contracts\Map<K, V>> $predicate
     *
     * Except for usage of the predicate, implementations should be consistent
     * with {@see self::put()}.
     *
     * @return bool
     */
    public function putIf(mixed $key, mixed $value, Predicate $predicate): bool;

    /**
     * Associate the provided value with the provided key in this map if the key doesn't
     * already exist
     *
     * Takes an argument of type K and an argument of type V and associate them
     * within this map if the key isn't already present.
     *
     * Implementations of this method may have additional constraints over whether
     * a particular pair can be added, in which case they should throw an
     * appropriate exception.
     *
     * Except for the check for whether a key is already present, implementations
     * should be consistent with {@see self::put()}.
     *
     * While not required, it is recommended that implementations of this method be
     * consistent with {@see self::putIf()}, as if the key check were a predicate.
     *
     * Determining whether a key is present should be consistent with {@see self::has()}.
     *
     * @param K $key
     * @param V $value
     *
     * @return bool
     */
    public function putIfAbsent(mixed $key, mixed $value): bool;

     /**
     * Remove a mapping for the provided key and return the value
     *
     * Takes an argument of type K and removes the value mapped to it, returning
     * the value if it was found, and null if it wasn't.
     *
     * @param K $key
     *
     * @return V|null
     */
    public function remove(mixed $key): mixed;

    /**
     * Remove all mappings for the provided keys and return them
     *
     * Takes an argument of type iterable<K> and removes all values that mapped to the keys,
     * returning a collection of {@see \Smpl\Collections\Contracts\Pair} containing the keys
     * and values removed.
     *
     * @param iterable<K> $keys
     *
     * @return \Smpl\Collections\Contracts\Collection<\Smpl\Collections\Contracts\Pair<K, V>>
     */
    public function removeAll(iterable $keys): Collection;

    /**
     * Convert this object into an array
     *
     * Returns an array consisting of the values stored within this map. If this maps
     * keys are valid array keys, they will be used, otherwise the key will be converted
     * into a string or int. If a key is unable to be converted, an exception will be
     * thrown.
     *
     * @return array<K|array-key, V>
     */
    public function toArray(): array;

    /**
     * Get a collection of the values from this map
     *
     * Returns a {@see \Smpl\Collections\Contracts\Collection} containing all values currently
     * present in this map.
     *
     * @return \Smpl\Collections\Contracts\Collection<V>
     */
    public function values(): Collection;
}
