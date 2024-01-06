<?php
declare(strict_types=1);

namespace Smpl\Collections\Support;

use ArrayIterator;
use Override;
use Smpl\Collections\Concerns\IsCountable;
use Smpl\Collections\Contracts\Collection;
use Smpl\Collections\Contracts\Map;
use Smpl\Collections\Contracts\Pair;
use Smpl\Collections\Contracts\Set as SetContract;
use Smpl\Collections\Iterators\KeyValuePairIterator;
use Smpl\Collections\Sequence;
use Smpl\Collections\Set;
use Smpl\Utilities\Contracts\Comparator;
use Smpl\Utilities\Contracts\Predicate;
use Traversable;

/**
 * @template K of mixed
 * @template V of mixed
 *
 * @implements \Smpl\Collections\Contracts\Map<K, V>
 */
class BaseMap implements Map
{
    use IsCountable;

    /**
     * @var array<array-key, \Smpl\Collections\Contracts\Pair<K, V>>
     */
    protected array $pairs = [];

    /**
     * @return \Traversable<K, V>
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return new KeyValuePairIterator($this->pairs);
    }

    /**
     * @return static
     */
    #[Override]
    public function clear(): static
    {
        $this->pairs = [];
        $this->setCount(0);

        return $this;
    }

    /**
     * @param V                                               $value
     * @param \Smpl\Utilities\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function contains(mixed $value, ?Comparator $comparator = null): bool
    {
        foreach ($this->pairs as $pair) {
            if ($comparator !== null && $comparator->isEqualTo($value, $pair->value())) {
                return true;
            }

            if ($value === $pair->value()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param iterable<V>                                     $values
     * @param \Smpl\Utilities\Contracts\Comparator<V, V>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function containsAll(iterable $values, ?Comparator $comparator = null): bool
    {
        foreach ($values as $value) {
            if (! $this->contains($value, $comparator)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return $this
     */
    #[Override]
    public function copy(): static
    {
        return clone $this;
    }

    /**
     * @param K $key
     *
     * @return \Smpl\Collections\Contracts\Pair<K, V>|null
     */
    protected function getPair(mixed $key): ?Pair
    {
        return $this->pairs[KeyValuePair::getTrueKey($key)] ?? null;
    }

    /**
     * @param K $key
     *
     * @return V|null
     */
    #[Override]
    public function get(mixed $key): mixed
    {
        return $this->getPair($key)?->value();
    }

    /**
     * @param K                                               $key
     * @param \Smpl\Utilities\Contracts\Comparator<K, K>|null $comparator
     *
     * @return bool
     */
    #[Override]
    public function has(mixed $key, ?Comparator $comparator = null): bool
    {
        if ($comparator) {
            return false;
        }

        return isset($this->pairs[KeyValuePair::getTrueKey($key)]);
    }

    /**
     * @param iterable<K> $keys
     *
     * @return bool
     */
    #[Override]
    public function hasAll(iterable $keys): bool
    {
        foreach ($keys as $key) {
            if (! $this->has($key)) {
                // If the key wasn't found, we'll short-circuit, no point carrying on.
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    #[Override]
    public function isEmpty(): bool
    {
        return false;
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
     * @return \Smpl\Collections\Contracts\Set<K>
     */
    #[Override]
    public function keys(): SetContract
    {
        $keys = [];

        foreach ($this->pairs as $pair) {
            $keys[] = $pair->key();
        }

        return new Set($keys);
    }

    /**
     * @return \Smpl\Collections\Contracts\Collection<\Smpl\Collections\Contracts\Pair<K, V>>
     */
    #[Override]
    public function pairs(): Collection
    {
        return new Sequence($this->pairs);
    }

    /**
     * @param K $key
     * @param V $value
     *
     * @return \Smpl\Collections\Contracts\Pair<K, V>
     */
    protected function makePair(mixed $key, mixed $value): Pair
    {
        return new KeyValuePair($key, $value);
    }

    /**
     * @param K $key
     * @param V $value
     *
     * @return static
     */
    #[Override]
    public function put(mixed $key, mixed $value): static
    {
        $trueKey               = KeyValuePair::getTrueKey($key);
        $this->pairs[$trueKey] = $this->makePair($key, $value);

        return $this;
    }

    /**
     * @param iterable<K, V>|iterable<Pair<K, V>> $map
     *
     * @return static
     */
    #[Override]
    public function putAll(iterable $map): static
    {
        if ($map instanceof Map) {
            /**
             * @var \Smpl\Collections\Contracts\Pair<K, V> $pair
             */
            foreach ($map->pairs() as $pair) {
                $this->put($pair->key(), $pair->value());
            }
        } else {
            /**
             * @var K $key
             * @var V $value
             */
            foreach ($map as $key => $value) {
                $this->put($key, $value);
            }
        }

        return $this;
    }

    /**
     * @param K                                                                          $key
     * @param V                                                                          $value
     * @param \Smpl\Utilities\Contracts\Predicate<\Smpl\Collections\Contracts\Map<K, V>> $predicate
     *
     * @return bool
     */
    #[Override]
    public function putIf(mixed $key, mixed $value, Predicate $predicate): bool
    {
        if ($predicate->test($this)) {
            $this->put($key, $value);

            return true;
        }

        return false;
    }

    /**
     * @param K $key
     * @param V $value
     *
     * @return bool
     */
    #[Override]
    public function putIfAbsent(mixed $key, mixed $value): bool
    {
        if ($this->has($key)) {
            return false;
        }

        $this->put($key, $value);

        return true;
    }

    /**
     * @param K $key
     *
     * @return V|null
     */
    #[Override]
    public function remove(mixed $key): mixed
    {
        if ($this->has($key)) {
            $value = $this->get($key);
            unset($this->pairs[KeyValuePair::getTrueKey($key)]);

            return $value;
        }

        return null;
    }

    /**
     * @param iterable<K> $keys
     *
     * @return \Smpl\Collections\Contracts\Collection<\Smpl\Collections\Contracts\Pair<K, V>>
     */
    #[Override]
    public function removeAll(iterable $keys): Collection
    {
        $removed = [];

        foreach ($keys as $key) {
            $pair = $this->getPair($key);

            if ($pair !== null) {
                $removed[] = $pair;
            }
        }

        return new Sequence($removed);
    }

    /**
     * @return array<array-key, V>
     */
    #[Override]
    public function toArray(): array
    {
        $array = [];

        foreach ($this->pairs as $pair) {
            $array[KeyValuePair::getTrueKey($pair->key())] = $pair->value();
        }

        return $array;
    }

    /**
     * @return \Smpl\Collections\Contracts\Collection<V>
     */
    #[Override]
    public function values(): Collection
    {
        $values = [];

        foreach ($this->pairs as $pair) {
            $values[] = $pair->value();
        }

        return new Sequence($values);
    }
}
