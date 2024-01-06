<?php
declare(strict_types=1);

namespace Smpl\Utilities\Comparators;

use Override;
use Smpl\Utilities\Support\BaseComparator;

/**
 * Space Comparator
 *
 * Represents an implementation of {@see \Smpl\Utilities\Contracts\Comparator} that
 * makes uses of PHPs inbuilt spaceship operator (<=>).
 *
 * @template P1 of mixed
 * @template P2 of mixed
 *
 * @extends \Smpl\Utilities\Support\BaseComparator<P1, P2>
 *
 * @psalm-immutable
 */
final class SpaceshipComparator extends BaseComparator
{
    /**
     * @param P1 $a
     * @param P2 $b
     *
     * @return int
     */
    #[Override]
    public function compare(mixed $a, mixed $b): int
    {
        return $a <=> $b;
    }
}
