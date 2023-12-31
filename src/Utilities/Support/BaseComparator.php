<?php
declare(strict_types=1);

namespace Smpl\Utilities\Support;

use Override;
use Smpl\Utilities\Contracts\Comparator;

/**
 * Base Comparator
 *
 * This is a base class that can be used by all {@see \Smpl\Utilities\Contracts\Comparator}
 * implementations to provide the base functionality.
 *
 * @template P1 of mixed
 * @template P2 of mixed
 *
 * @implements \Smpl\Utilities\Contracts\Comparator<P1, P2>
 *
 * @psalm-immutable
 */
abstract class BaseComparator implements Comparator
{
    /**
     * @param P1 $a
     * @param P2 $b
     *
     * @return bool
     */
    #[Override]
    public function isLessThan(mixed $a, mixed $b): bool
    {
        return $this->compare($a, $b) < 0;
    }

    /**
     * @param P1 $a
     * @param P2 $b
     *
     * @return bool
     */
    #[Override]
    public function isGreaterThan(mixed $a, mixed $b): bool
    {
        return $this->compare($a, $b) > 0;
    }

    /**
     * @param P1 $a
     * @param P2 $b
     *
     * @return bool
     */
    #[Override]
    public function isEqualTo(mixed $a, mixed $b): bool
    {
        return $this->compare($a, $b) === 0;
    }
}
