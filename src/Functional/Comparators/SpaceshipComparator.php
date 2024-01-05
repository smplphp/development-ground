<?php
declare(strict_types=1);

namespace Smpl\Functional\Comparators;

use Override;
use Smpl\Functional\Support\BaseComparator;

/**
 * Space Comparator
 *
 * Represents an implementation of {@see \Smpl\Functional\Contracts\Comparator} that
 * makes uses of PHPs inbuilt spaceship operator (<=>).
 *
 * @template P1 of mixed
 * @template P2 of mixed
 *
 * @extends \Smpl\Functional\Support\BaseComparator<P1, P2>
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
