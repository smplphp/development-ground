<?php
declare(strict_types=1);

namespace Smpl\Collections\Support;

use ArrayIterator;
use Override;
use Smpl\Collections\Contracts\Collection;
use Smpl\Functional\Contracts\Comparator;
use Smpl\Functional\Contracts\Predicate;
use Traversable;

/**
 * Base Collection
 *
 * This is a base class that provides a full default implementation of the
 * {@see \Smpl\Collections\Contracts\Collection} contract.
 *
 * @template P of mixed
 *
 * @implements \Smpl\Collections\Contracts\Collection<P>
 */
abstract class BaseCollection implements Collection
{
    /**
     * The elements in the collection
     *
     * @var array<int, P>
     */
    protected array $elements = [];

    /**
     * The number of elements in the collection
     *
     * @var int<0, max>
     */
    protected int $count = 0;

    /**
     * @param iterable<P> $elements
     */
    public function __construct(iterable $elements = [])
    {
        if (! empty($elements)) {
            $this->addAll($elements);
        }
    }

    /**
     * Modify the current element count
     *
     * @param int $count
     *
     * @return void
     */
    protected function modifyCount(int $count = 1): void
    {
        $this->setCount($this->count + $count);
    }

    /**
     * Set the current element count
     *
     * Takes an integer that will be clamped to be a minimum of 0, before
     * being set as the current element count.
     *
     * @param int $count
     *
     * @return void
     */
    protected function setCount(int $count): void
    {
        $this->count = max(0, $count);
    }

    /**
     * @param P $element
     *
     * @return bool
     */
    #[Override]
    public function add(mixed $element): bool
    {
        $this->elements[] = $element;
        $this->modifyCount();

        return true;
    }

    /**
     * @param iterable<P> $elements
     *
     * @return bool
     */
    #[Override]
    public function addAll(iterable $elements): bool
    {
        $result = false;

        foreach ($elements as $element) {
            if ($this->add($element)) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * @return static
     */
    #[Override]
    public function clear(): static
    {
        if ($this->isNotEmpty()) {
            $this->elements = [];
            $this->setCount(0);
        }

        return $this;
    }

    /**
     * Find the index of an element
     *
     * Takes an argument of type P and an optional {@see \Smpl\Functional\Contracts\Comparator},
     * which is then used to locate the first index of the element within this collection. If no
     * index is found, false is returned.
     *
     * @param P                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return false|int
     */
    protected function findIndexOf(mixed $element, ?Comparator $comparator = null): false|int
    {
        if ($comparator !== null) {
            return $this->findIndexOfWithComparator($element, $comparator);
        }

        return array_search($element, $this->elements, true);
    }

    /**
     * Find the index of an element using a comparator
     *
     * An expansion on {@see self::findIndexOf()} to specifically deal with cases where a
     * {@see \Smpl\Functional\Contracts\Comparator} is provided.
     *
     * @param P                                           $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P> $comparator
     *
     * @return false|int
     */
    protected function findIndexOfWithComparator(mixed $element, Comparator $comparator): false|int
    {
        foreach ($this->elements as $index => $existingElement) {
            if ($comparator->isEqualTo($existingElement, $element)) {
                return $index;
            }
        }

        return false;
    }

    /**
     * @param P                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function contains(mixed $element, ?Comparator $comparator = null): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        return $this->findIndexOf($element, $comparator) !== false;
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function containsAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        foreach ($elements as $element) {
            if (! $this->contains($element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return static
     */
    #[Override]
    public function copy(): static
    {
        return clone $this;
    }

    /**
     * @return bool
     */
    #[Override]
    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    /**
     * @return bool
     */
    #[Override]
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * Remove an element by its index/key
     *
     * Takes an argument of type int, and unsets it from this collections' elements.
     *
     * @param int $index
     *
     * @return void
     */
    protected function removeByIndex(int $index): void
    {
        unset($this->elements[$index]);
        $this->modifyCount(-1);
    }

    /**
     * @param P                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function remove(mixed $element, ?Comparator $comparator = null): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        $index = $this->findIndexOf($element);

        if ($index === false) {
            return false;
        }

        $this->removeByIndex($index);

        return true;
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function removeAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        $result = false;

        foreach ($elements as $element) {
            if ($this->remove($element, $comparator)) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return bool
     */
    #[Override]
    public function removeIf(Predicate $predicate): bool
    {
        $result = false;

        foreach ($this->elements as $index => $element) {
            if ($predicate->test($element)) {
                $this->removeByIndex($index);
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Compares two elements to determine whether they're equal
     *
     * Takes two arguments of type P and compares them for equality. If a comparator is provided,
     * that will be used to compare the elements.
     *
     * @param P                                                $element1
     * @param P                                                $element2
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    protected function areElementsEqual(mixed $element1, mixed $element2, ?Comparator $comparator = null): bool
    {
        return $comparator === null ? ($element1 === $element2) : $comparator->isEqualTo($element1, $element2);
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function retainAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        $result = false;

        foreach ($this->elements as $index => $existingElement) {
            foreach ($elements as $element) {
                if (! $this->areElementsEqual($existingElement, $element)) {
                    $this->removeByIndex($index);
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return bool
     */
    #[Override]
    public function retainIf(Predicate $predicate): bool
    {
        // Since this method is an inverse of removeIf, let's flip it around and
        // piggyback on that.
        return $this->removeIf($predicate->negate());
    }

    /**
     * @return \Traversable<int, P>
     */
    #[Override]
    public function getIterator(): Traversable
    {
        // TODO: Replace this with a better iterator
        return new ArrayIterator($this->elements);
    }

    /**
     * @return int<0, max>
     */
    #[Override]
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @return array<int, P>
     */
    #[Override]
    public function toArray(): array
    {
        return $this->elements;
    }
}
