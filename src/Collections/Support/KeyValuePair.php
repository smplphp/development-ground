<?php
declare(strict_types=1);

namespace Smpl\Collections\Support;

use Override;
use RuntimeException;
use Smpl\Collections\Contracts\Identifiable;
use Smpl\Collections\Contracts\Pair;
use Smpl\Collections\Exceptions\InvalidKeyException;
use Stringable;

/**
 * @template K of mixed
 * @template V of mixed
 *
 * @implements \Smpl\Collections\Contracts\Pair<K, V>
 *
 * @phpstan-pure
 * @psalm-immutable
 * @psalm-pure
 */
final class KeyValuePair implements Pair
{
    /**
     * @template RK of mixed
     *
     * @param RK $key
     *
     * @return array-key
     */
    public static function getTrueKey(mixed $key): int|string
    {
        $trueKey = null;

        if (is_object($key)) {
            if ($key instanceof Identifiable) {
                $trueKey = $key->identity();
            } else if ($key instanceof Stringable) {
                $trueKey = $key->__toString();
            } else {
                $trueKey = spl_object_hash($key);
            }
        } else if (is_string($key) || is_int($key)) {
            $trueKey = $key;
        }

        if ($trueKey === null) {
            throw InvalidKeyException::make();
        }

        return $trueKey;
    }

    /**
     * @var K
     */
    private mixed $key;

    /**
     * @var V
     */
    private mixed $value;

    /**
     * @param K $key
     * @param V $value
     */
    public function __construct(mixed $key, mixed $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * @return K
     */
    #[Override]
    public function key(): mixed
    {
        return $this->key;
    }

    /**
     * @return V
     */
    #[Override]
    public function value(): mixed
    {
        return $this->value;
    }
}
