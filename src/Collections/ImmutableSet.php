<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Exceptions\UnsupportedOperationException;
use Smpl\Collections\Support\BaseSequence;
use Smpl\Utilities\Contracts\Comparator;
use Smpl\Utilities\Contracts\Predicate;

/**
 * Immutable Set
 *
 * Represents an immutable implementation of the {@see \Smpl\Collections\Contracts\Set}
 * contract.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Collections\Support\BaseSequence<P>
 * @implements \Smpl\Collections\Contracts\Set<P>
 *
 * @psalm-immutable
 * @psalm-suppress MutableDependency
 */
final class ImmutableSet extends BaseSequence implements Contracts\Set
{
    /**
     * @var \Smpl\Utilities\Contracts\Comparator<P, P>|null
     */
    private ?Comparator $uniqueConstraint;

    /**
     * @param iterable<P>                                     $elements
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $uniqueConstraint
     *
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(iterable $elements = [], ?Comparator $uniqueConstraint = null)
    {
        // It's important that the unique constraint is set before the parent constructor is called,
        // so that comparison logic is consistent.
        $this->uniqueConstraint = $uniqueConstraint;

        if (! empty($elements)) {
            // We have to do this manually rather than use addAll() because that
            // will return false
            foreach ($elements as $element) {
                if (! $this->isNotUnique($element)) {
                    $this->elements[] = $element;
                    $this->modifyCount();
                }
            }
        }
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
     */
    protected function isNotUnique(mixed $element): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        return $this->contains($element, $this->uniqueConstraint);
    }

    /**
     * @param array<P> $elements
     *
     * @return static
     */
    #[Override]
    protected function create(array $elements): static
    {
        return new static($elements);
    }

    /**
     * @param P $element
     *
     * @return bool
     */
    #[Override]
    public function add(mixed $element): bool
    {
        return false;
    }

    /**
     * @param iterable<P> $elements
     *
     * @return bool
     */
    #[Override]
    public function addAll(iterable $elements): bool
    {
        return false;
    }

    /**
     * @return never
     */
    #[Override]
    public function clear(): never
    {
        throw UnsupportedOperationException::immutable(__CLASS__, __METHOD__);
    }

    /**
     * @param P                                               $element
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function remove(mixed $element, ?Comparator $comparator = null): bool
    {
        return false;
    }

    /**
     * @param iterable<P>                                     $elements
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function removeAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return false;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
     *
     * @return bool
     */
    #[Override]
    public function removeIf(Predicate $predicate): bool
    {
        return false;
    }

    /**
     * @param iterable<P>                                     $elements
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function retainAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return false;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<P> $predicate
     *
     * @return bool
     */
    #[Override]
    public function retainIf(Predicate $predicate): bool
    {
        return false;
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    #[Override]
    public function forget(int $index): bool
    {
        return false;
    }

    /**
     * @param int $index
     * @param P   $element
     *
     * @return bool
     */
    #[Override]
    public function insert(int $index, mixed $element): bool
    {
        return false;
    }

    /**
     * @param int         $index
     * @param iterable<P> $elements
     *
     * @return bool
     */
    #[Override]
    public function insertAll(int $index, iterable $elements): bool
    {
        return false;
    }

    /**
     * @param int $index
     * @param P   $element
     *
     * @return bool
     */
    #[Override]
    public function set(int $index, mixed $element): bool
    {
        return false;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Comparator<P, P> $comparator
     *
     * @return never
     */
    #[Override]
    public function sort(Comparator $comparator): never
    {
        throw UnsupportedOperationException::immutable(__CLASS__, __METHOD__);
    }

    /**
     * Get a mutable version of this collection
     *
     * Returns a new collection instance containing all the elements this collection does,
     * but the resulting collection is mutable, allowing modification.
     *
     * @return \Smpl\Collections\Contracts\Set<P>
     */
    public function mutable(): Contracts\Set
    {
        return new Set($this->elements, $this->uniqueConstraint);
    }
}
