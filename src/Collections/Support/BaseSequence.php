<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections\Support;

use Override;
use Smpl\Collections\Contracts;
use Smpl\Collections\Exceptions\IndexOutOfRangeException;
use Smpl\Utilities\Contracts\Comparator;

/**
 * Base Sequence
 *
 * This is a base class that provides a full default implementation of the
 * {@see \Smpl\Collections\Contracts\Sequence} contract.
 *
 * @template P of mixed
 *
 * @implements \Smpl\Collections\Contracts\Sequence<P>
 * @extends \Smpl\Collections\Support\BaseCollection<P>
 */
abstract class BaseSequence extends BaseCollection implements Contracts\Sequence
{
    /**
     * @param int $index
     *
     * @return void
     */
    protected function removeByIndex(int $index): void
    {
        // This will cause the sequential keys to be recalculated, which is what we want.
        array_splice($this->elements, $index, 1);
        $this->modifyCount(-1);
    }

    /**
     * Checks whether the provided index is within the acceptable range for this collection
     *
     * Takes an argument of type int as the index, a boolean to define whether the range is inclusive,
     * and another boolean to define whether negative numbers are allowed. Returns nothing but
     * throws a {@see \Smpl\Collections\Exceptions\IndexOutOfRangeException} if the provided index
     * is outside the calculated range.
     *
     * @param int  $index
     * @param bool $inclusive
     * @param bool $allowNegative
     *
     * @return void
     *
     * @throws \Smpl\Collections\Exceptions\IndexOutOfRangeException If the provided index is outside the calculated range
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    protected function checkIndexRange(int $index, bool $inclusive = true, bool $allowNegative = false): void
    {
        if ($index < 0 && ! $allowNegative) {
            throw IndexOutOfRangeException::index($index, 0, $this->count(), $inclusive);
        }

        if ($allowNegative && $index < 0 && abs($index) >= $this->count()) {
            throw IndexOutOfRangeException::index($index, 0, $this->count(), $inclusive);
        }

        if (($inclusive && $index > $this->count()) || (! $inclusive && $inclusive >= $this->count())) {
            throw IndexOutOfRangeException::index($index, 0, $this->count(), $inclusive);
        }
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    #[Override]
    public function forget(int $index): bool
    {
        $this->checkIndexRange($index, false);

        $this->removeByIndex($index);

        return true;
    }

    /**
     * @param int $index
     *
     * @return P|null
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    #[Override]
    public function get(int $index): mixed
    {
        $this->checkIndexRange($index, false);

        return $this->elements[$index];
    }

    /**
     * @param P                                               $element
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $comparator
     *
     * @return int|false
     */
    #[Override]
    public function indexOf(mixed $element, ?Comparator $comparator = null): int|false
    {
        return $this->findIndexOf($element, $comparator);
    }

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
     * This implementation imposes no additional constraints on what can and cannot
     * be added to the collection.
     *
     * Attempting to insert an element as index n where n is the current element
     * count should function as if {@see self::add()} were called instead.
     *
     * This method is an alternative to {@see self::add()} that allows finer control
     * over where in the sequence an element is inserted.
     *
     * @param int $index
     * @param P   $element
     *
     * @return bool
     */
    #[Override]
    public function insert(int $index, mixed $element): bool
    {
        $this->checkIndexRange($index);

        if ($index === $this->count()) {
            return $this->add($element);
        }

        array_splice($this->elements, $index, 0, [$element]);
        $this->modifyCount();

        return true;
    }

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
     * This implementation imposes no additional constraints on what can and cannot
     * be added to the collection.
     *
     * Attempting to insert elements as index n where n is the current element
     * count should function as if {@see self::addAll()} were called instead.
     *
     * This method is an alternative to {@see self::addAll()} that allows finer control
     * over where in the sequence the elements are inserted.
     *
     * Implementations of this method must be consistent with {@see self::insert()}.
     *
     * @param int         $index
     * @param iterable<P> $elements
     *
     * @return bool
     */
    #[Override]
    public function insertAll(int $index, iterable $elements): bool
    {
        $this->checkIndexRange($index);

        $result = false;

        foreach ($elements as $element) {
            if ($this->insert($index, $element)) {
                $result = true;
                $index++;
            }
        }

        return $result;
    }

    /**
     * Replaces an element at the provided position
     *
     * Takes in argument of type int to act as an index, and another of type V
     * which is the element to be inserted, returning true if inserted, and false
     * otherwise. Provided indexes should be within the range of <0, n-1>.
     *
     * The provided element will overwrite elements that exist at the provided index.
     *
     * This implementation imposes no additional constraints on what can and cannot
     * be added to the collection.
     *
     * This method is an alternative to {@see self::insert()} that replaces the element
     * rather than shift it.
     *
     * @param int $index
     * @param P   $element
     *
     * @return bool
     */
    #[Override]
    public function set(int $index, mixed $element): bool
    {
        $this->checkIndexRange($index, false);

        $this->elements[$index] = $element;

        return true;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Comparator<P, P> $comparator
     *
     * @return static
     */
    #[Override]
    public function sort(Comparator $comparator): static
    {
        usort($this->elements, $comparator->compare(...));

        return $this;
    }

    /**
     * Create a new instance of this collection with the provided elements
     *
     * Takes an argument of type array<P> and returns a new instance of this implementation
     * populated with the provided elements.
     *
     * This method exists to provide a safe way for this base class to create new instances of
     * itself.
     *
     * @param array<P> $elements
     *
     * @return static
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    abstract protected function create(array $elements): static;

    /**
     * Returns a new collection of elements that exist within the provided range
     *
     * Takes two arguments of type int with the first specifying the start of the range,
     * and the second specifying the number of elements. This method will then return a
     * new instance of this collection containing only the elements that exist within
     * the range of <i, i+c> where i is the index and c is the count.
     *
     * This implementation allows for both a negative index and count, and its behaviour
     * is consistent with {@see \array_slice()}.
     *
     * @param int $index
     * @param int $count
     *
     * @return static
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    #[Override]
    public function slice(int $index, int $count): static
    {
        return $this->create(array_slice($this->elements, $index, $count));
    }
}
