<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Collections;

use Override;
use Smpl\Collections\Support\BaseSequence;
use Smpl\Utilities\Contracts\Comparator;

/**
 * Sequence
 *
 * Represents a specialised collection that stores elements in
 * a sequential list. Removing elements will also shift the indexes of subsequent
 * elements to the left ($index - 1), meaning indexes are always in the range of
 * <0, n-1> where n is the current element count.
 *
 * Sequences also have additional methods for inserting, removing and retrieving
 * elements by their index.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Collections\Support\BaseSequence<P>
 */
final class Sequence extends BaseSequence
{
    /**
     * @param iterable<P> $elements
     *
     * @noinspection SenselessProxyMethodInspection
     * */
    public function __construct(iterable $elements = [])
    {
        // This constructor is here because PHPStan complains if it isn't, and is able to
        // follow the P template hierarchy.
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
        return new static($elements);
    }

    /**
     * Get a new collection containing all unique elements
     *
     * Takes an optional argument of type Comparator<P, P> that will be used to determine
     * an elements uniqueness within the collection, returning a new sequence of type
     * {@see \Smpl\Collections\Set} that contains only one instance of each unique
     * element.
     *
     * @param \Smpl\Utilities\Contracts\Comparator<P, P>|null $comparator
     *
     * @return \Smpl\Collections\Contracts\Set<P>
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    public function unique(?Comparator $comparator = null): Contracts\Set
    {
        return new Set($this->elements, $comparator);
    }

    /**
     * Get an immutable version of this collection
     *
     * Returns a new collection instance containing all the elements this collection does,
     * but the resulting collection is immutable, and cannot be modified in any way.
     *
     * @return \Smpl\Collections\Contracts\Sequence<P>
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    public function immutable(): Contracts\Sequence
    {
        return new ImmutableSequence($this->elements);
    }
}
