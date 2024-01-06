<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Support\BaseSequence;
use Smpl\Utilities\Contracts\Comparator;

/**
 * Set
 *
 * @template P of mixed
 *
 * @extends \Smpl\Collections\Support\BaseSequence<P>
 * @implements \Smpl\Collections\Contracts\Set<P>
 */
final class Set extends BaseSequence implements Contracts\Set
{
    /**
     * @var \Smpl\Utilities\Contracts\Comparator<P, P>|null
     */
    private ?Comparator $uniqueConstraint;

    /**
     * @param iterable<P>                                     $elements
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $uniqueConstraint
     */
    public function __construct(iterable $elements = [], ?Comparator $uniqueConstraint = null)
    {
        // It's important that the unique constraint is set before the parent constructor is called,
        // so that comparison logic is consistent.
        $this->uniqueConstraint = $uniqueConstraint;

        parent::__construct($elements);
    }

    /**
     * @param array<P> $elements
     *
     * @return static
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    #[Override]
    protected function create(array $elements): static
    {
        return new self($elements, $this->uniqueConstraint);
    }

    /**
     * Determine whether a provided element is unique within this collection
     *
     * Takes an argument of type P and checks if it is contained within the collection, optionally
     * using the unique constraint comparator if one was provided.
     *
     * @param P $element
     *
     * @return bool
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    protected function isNotUnique(mixed $element): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        return $this->contains($element, $this->uniqueConstraint);
    }

    /**
     * Add an element to this collection
     *
     * Takes an argument of type V and adds it to this collection, returning true
     * if it was successful, and false otherwise.
     *
     * Elements are added to the end of the collection if they are considered unique
     * within the collection, according to the default {@see self::contains()} implementation,
     * or the {@see self::$uniqueConstraint} if one is present.
     *
     * @param P $element
     *
     * @return bool
     */
    #[Override]
    public function add(mixed $element): bool
    {
        // If there's an element within the collection that is considered equal to the provided element,
        // we want to return false because it can't be added.
        if ($this->isNotUnique($element)) {
            return false;
        }

        return parent::add($element);
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
     * Elements are added to the collection if they are considered unique within the
     * collection, according to the default {@see self::contains()} implementation,
     * or the {@see self::$uniqueConstraint} if one is present.
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
        // If there's an element within the collection that is considered equal to the provided element,
        // we want to return false because it can't be added.
        if ($this->isNotUnique($element)) {
            return false;
        }

        return parent::insert($index, $element);
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
     * Elements are added to the collection if they are considered unique within the
     * collection, according to the default {@see self::contains()} implementation,
     * or the {@see self::$uniqueConstraint} if one is present. An element may still be
     * added to the collection if it is not considered unique, when replacing the other
     * element that it is considered equal to.
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
        // If there's an element within the collection that is considered equal to the provided element,
        // we want to return false because it can't be added. However, if we're replacing an element
        // with one that is considered equal, we'll allow that.
        if ($this->isNotUnique($element) && $this->findIndexOf($element, $this->uniqueConstraint) !== $index) {
            return false;
        }

        return parent::set($index, $element);
    }
}
