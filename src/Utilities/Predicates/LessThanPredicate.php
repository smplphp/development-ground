<?php
declare(strict_types=1);

namespace Smpl\Utilities\Predicates;

use Override;
use Smpl\Utilities\Support\BasePredicate;

/**
 * Less Than Predicate
 *
 * Represents a comparative less-than of two values.
 *
 * @extends \Smpl\Utilities\Support\BasePredicate<int|float>
 */
final class LessThanPredicate extends BasePredicate
{
    private int|float $subject;

    public function __construct(int|float $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param int|float $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $value < $this->subject;
    }
}
