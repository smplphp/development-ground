<?php
declare(strict_types=1);

namespace Smpl\Collections\Decorators;

use Smpl\Collections\Contracts\Collection;
use Smpl\Collections\Contracts\Sequence;

/**
 * Sequence Decorator
 *
 * Provides decorator functionality for classes that wish to decorate the
 * {@see \Smpl\Collections\Contracts\Sequence} contract.
 *
 * @template P of mixed
 *
 * @mixin \Smpl\Collections\Contracts\Sequence
 * @requires \Smpl\Collections\Contracts\Sequence
 * @psalm-require-implements \Smpl\Collections\Contracts\Sequence
 */
trait DecoratesSequence
{
    /**
     * @uses \Smpl\Collections\Decorators\DecoratesCollection<P>
     */
    use DecoratesCollection;

    /**
     * Get the sequence this class is decorating
     *
     * @return \Smpl\Collections\Contracts\Sequence<P>
     */
    abstract protected function getSequence(): Sequence;

    /**
     * @return \Smpl\Collections\Contracts\Collection<P>
     */
    protected function getCollection(): Collection
    {
        // Since the Sequence contract is a child of Collection, we can just
        // piggyback through that here, so we don't have to redefine a bunch of methods.
        return $this->getSequence();
    }
}
