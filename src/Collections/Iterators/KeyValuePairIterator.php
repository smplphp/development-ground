<?php
declare(strict_types=1);

namespace Smpl\Collections\Iterators;

use Countable;
use Override;
use SeekableIterator;

/**
 * @template K of mixed
 * @template V of mixed
 *
 * @implements \SeekableIterator<K, V>
 */
final class KeyValuePairIterator implements SeekableIterator, Countable
{
    /**
     * @var array<\Smpl\Collections\Contracts\Pair<K, V>>
     */
    private array $pairs;

    /**
     * @param array<\Smpl\Collections\Contracts\Pair<K, V>> $pairs
     */
    public function __construct(array $pairs)
    {
        $this->pairs = $pairs;
    }

    /**
     * @return V|null
     */
    #[Override]
    public function current(): mixed
    {
        $pair = current($this->pairs);

        return $pair ? $pair->value() : null;
    }

    /**
     * @return void
     */
    #[Override]
    public function next(): void
    {
        next($this->pairs);
    }

    /**
     * @return K|null
     */
    #[Override]
    public function key(): mixed
    {
        $pair = current($this->pairs);

        return $pair ? $pair->key() : null;
    }

    /**
     * @return bool
     */
    #[Override]
    public function valid(): bool
    {
        return $this->current() !== null;
    }

    /**
     * @return void
     */
    #[Override]
    public function rewind(): void
    {
        prev($this->pairs);
    }

    /**
     * @return int
     */
    #[Override]
    public function count(): int
    {
        return count($this->pairs);
    }

    /**
     * @param int $offset
     *
     * @return void
     */
    #[Override]
    public function seek(int $offset): void
    {
        reset($this->pairs);

        for ($i = 0; $i < $offset; $i++) {
            $this->next();

            if (! $this->valid()) {
                return;
            }
        }
    }
}
