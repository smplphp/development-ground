<?php
declare(strict_types=1);

namespace Smpl\Collections\Concerns;

/**
 * Is Countable Concern
 *
 * Helper trait for classes that are countable.
 *
 * @mixin \Countable
 * @requires \Countable
 * @psalm-require-implements \Countable
 */
trait IsCountable
{
    /**
     * The number of elements in the collection
     *
     * @var int<0, max>
     */
    protected int $count = 0;

    /**
     * @return int<0, max>
     *
     * @phpstan-pure
     * @psalm-mutation-free
     */
    public function count(): int
    {
        return $this->count;
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
}
