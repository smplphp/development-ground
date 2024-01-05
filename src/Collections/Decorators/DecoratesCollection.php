<?php
declare(strict_types=1);

namespace Smpl\Collections\Decorators;

use Smpl\Collections\Contracts\Collection;
use Smpl\Functional\Contracts\Comparator;
use Smpl\Functional\Contracts\Predicate;
use Traversable;

/**
 * Collection Decorator
 *
 * Provides decorator functionality for classes that wish to decorate the
 * {@see \Smpl\Collections\Contracts\Collection} contract.
 *
 * @template P of mixed
 *
 * @mixin \Smpl\Collections\Contracts\Collection
 * @requires \Smpl\Collections\Contracts\Collection
 * @psalm-require-implements \Smpl\Collections\Contracts\Collection
 */
trait DecoratesCollection
{
    /**
     * Get the collection this class is decorating
     *
     * @return \Smpl\Collections\Contracts\Collection<P>
     */
    abstract protected function getCollection(): Collection;

    /**
     * @param P $element
     *
     * @return bool
     */
    public function add(mixed $element): bool
    {
        return $this->getCollection()->add($element);
    }

    /**
     * @param iterable<P> $elements
     *
     * @return bool
     */
    public function addAll(iterable $elements): bool
    {
        return $this->getCollection()->addAll($elements);
    }

    /**
     * @return static
     */
    public function clear(): static
    {
        $this->getCollection()->clear();

        return $this;
    }

    /**
     * @param P                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    public function contains(mixed $element, ?Comparator $comparator = null): bool
    {
        return $this->getCollection()->contains($element, $comparator);
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    public function containsAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return $this->getCollection()->containsAll($elements, $comparator);
    }

    /**
     * @return static
     */
    public function copy(): static
    {
        return clone $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->getCollection()->isEmpty();
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return $this->getCollection()->isNotEmpty();
    }

    /**
     * @param P                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    public function remove(mixed $element, ?Comparator $comparator = null): bool
    {
        return $this->getCollection()->remove($element, $comparator);
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    public function removeAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return $this->getCollection()->removeAll($elements, $comparator);
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return bool
     */
    public function removeIf(Predicate $predicate): bool
    {
        return $this->getCollection()->removeIf($predicate);
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    public function retainAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return $this->getCollection()->retainAll($elements, $comparator);
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return bool
     */
    public function retainIf(Predicate $predicate): bool
    {
        return $this->getCollection()->retainIf($predicate);
    }

    /**
     * @return \Traversable<int, P>
     *
     * @throws \Exception
     */
    public function getIterator(): Traversable
    {
        return $this->getCollection()->getIterator();
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->getCollection()->count();
    }

    /**
     * @return array<int, P>
     */
    public function toArray(): array
    {
        return $this->getCollection()->toArray();
    }
}
