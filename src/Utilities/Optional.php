<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Utilities;

use Smpl\Utilities\Contracts\Consumer;
use Smpl\Utilities\Contracts\Predicate;
use Smpl\Utilities\Contracts\Supplier;

/**
 * Optional Class
 *
 * Represents the holder of a value, or null. Instead of returning null or the value,
 * classes can opt to instead return an instance of this class, providing the user with
 * a fluent way of determining the presence of a value, with a few additional controls.
 *
 * @template T of mixed
 */
final class Optional
{
    /**
     * @return \Smpl\Utilities\Optional<null>
     */
    public static function empty(): Optional
    {
        return new static(null);
    }

    /**
     * @var T|null
     */
    private mixed $value;

    /**
     * @param T|null $value
     */
    public function __construct(mixed $value = null)
    {
        $this->value = $value;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Predicate<T> $predicate
     *
     * @return T|\Smpl\Utilities\Optional<null>
     */
    public function filter(Predicate $predicate): mixed
    {
        if ($this->isPresent() && $predicate->test($this->get())) {
            return $this->get();
        }

        return self::empty();
    }

    /**
     * @return T
     */
    public function get(): mixed
    {
        if (! $this->isPresent()) {
            throw new \RuntimeException('No, no, no');
        }

        return $this->value;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Consumer<T> $consumer
     *
     * @return static
     */
    public function ifPresent(Consumer $consumer): static
    {
        if ($this->isPresent()) {
            $consumer->perform($this->get());
        }

        return $this;
    }

    /**
     * @return bool
     *
     * @phpstan-assert-if-true T $this->get()
     * @phpstan-assert-if-true T $this->value
     * @psalm-assert-if-true T $this->get()
     * @psalm-assert-if-true T $this->value
     */
    public function isPresent(): bool
    {
        return $this->value !== null;
    }

    /**
     * @param T $other
     *
     * @return T
     */
    public function orElse(mixed $other): mixed
    {
        return $this->isPresent() ? $this->get() : $other;
    }

    /**
     * @param \Smpl\Utilities\Contracts\Supplier<T> $supplier
     *
     * @return T
     */
    public function orElseGet(Supplier $supplier): mixed
    {
        return $this->isPresent() ? $this->get() : $supplier->get();
    }

    /**
     * @param \Smpl\Utilities\Contracts\Supplier<\Throwable> $supplier
     *
     * @return T
     *
     * @throws \Throwable
     */
    public function orElseThrow(Supplier $supplier): mixed
    {
        if ($this->isPresent()) {
            return $this->get();
        }

        throw $supplier->get();
    }
}
