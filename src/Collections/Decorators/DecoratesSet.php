<?php
declare(strict_types=1);

namespace Smpl\Collections\Decorators;

use Smpl\Collections\Contracts\Sequence;
use Smpl\Collections\Contracts\Set;

/**
 * Set Decorator
 *
 * Provides decorator functionality for classes that wish to decorate the
 * {@see \Smpl\Collections\Contracts\Set} contract.
 *
 * @template P of mixed
 *
 * @mixin \Smpl\Collections\Contracts\Set
 * @requires \Smpl\Collections\Contracts\Set
 * @psalm-require-implements \Smpl\Collections\Contracts\Set
 */
trait DecoratesSet
{
    /**
     * @uses \Smpl\Collections\Decorators\DecoratesSequence<P>
     */
    use DecoratesSequence;

    /**
     * Get the sequence this class is decorating
     *
     * @return \Smpl\Collections\Contracts\Set<P>
     */
    abstract protected function getSet(): Set;

    /**
     * @return \Smpl\Collections\Contracts\Sequence<P>
     */
    protected function getSequence(): Sequence
    {
        // Since the Set contract is a child of Sequence, we can just
        // piggyback through that here, so we don't have to redefine a bunch of methods.
        return $this->getSet();
    }
}
