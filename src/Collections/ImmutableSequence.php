<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Exceptions\UnsupportedOperationException;
use Smpl\Collections\Support\BaseSequence;
use Smpl\Functional\Contracts\Comparator;
use Smpl\Functional\Contracts\Predicate;

/**
 * Immutable Sequence
 *
 * Represents an immutable implementation of the {@see \Smpl\Collections\Contracts\Sequence}
 * contract.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Collections\Support\BaseSequence<P>
 *
 * @psalm-immutable
 * @psalm-suppress MutableDependency
 */
final class ImmutableSequence extends BaseSequence
{
    /**
     * @param iterable<P> $elements
     *
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(iterable $elements = [])
    {
        // We have to do this manually rather than use addAll() because that will return false
        foreach ($elements as $element) {
            $this->elements[] = $element;
            $this->modifyCount();
        }
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
     *
     * @psalm-immutable
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
     *
     * @psalm-immutable
     */
    #[Override]
    public function addAll(iterable $elements): bool
    {
        return false;
    }

    /**
     * @return never
     *
     * @psalm-immutable
     */
    #[Override]
    public function clear(): never
    {
        throw UnsupportedOperationException::immutable(__CLASS__, __METHOD__);
    }

    /**
     * @param P                                                $element
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     *
     * @psalm-immutable
     */
    #[Override]
    public function remove(mixed $element, ?Comparator $comparator = null): bool
    {
        return false;
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     *
     * @psalm-immutable
     */
    #[Override]
    public function removeAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return false;
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return bool
     *
     * @psalm-immutable
     */
    #[Override]
    public function removeIf(Predicate $predicate): bool
    {
        return false;
    }

    /**
     * @param iterable<P>                                      $elements
     * @param \Smpl\Functional\Contracts\Comparator<P, P>|null $comparator
     *
     * @return bool
     *
     * @psalm-immutable
     */
    #[Override]
    public function retainAll(iterable $elements, ?Comparator $comparator = null): bool
    {
        return false;
    }

    /**
     * @param \Smpl\Functional\Contracts\Predicate<P> $predicate
     *
     * @return bool
     *
     * @psalm-immutable
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
     *
     * @psalm-immutable
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
     *
     * @psalm-immutable
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
     *
     * @psalm-immutable
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
     *
     * @psalm-immutable
     */
    #[Override]
    public function set(int $index, mixed $element): bool
    {
        return false;
    }

    /**
     * @param \Smpl\Functional\Contracts\Comparator<P, P> $comparator
     *
     * @return never
     *
     * @psalm-immutable
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
     * @return \Smpl\Collections\Contracts\Sequence<P>
     *
     * @psalm-immutable
     */
    public function mutable(): Contracts\Sequence
    {
        return new Sequence($this->elements);
    }
}
