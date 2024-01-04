<?php
declare(strict_types=1);

namespace Smpl\Functional\Functions;

use Override;
use Smpl\Functional\Support\BaseFunc;

/**
 * Modulo Function
 *
 * Represents an implementation of {@see \Smpl\Functional\Contracts\Func} that performs
 * a modulo operation using the % operator.
 *
 * @extends \Smpl\Functional\Support\BaseFunc<int, int>
 */
final class ModuloFunc extends BaseFunc
{
    private int $divisor;

    public function __construct(int $divisor)
    {
        $this->divisor = $divisor;
    }

    /**
     * @param int $value
     *
     * @return int
     */
    #[Override]
    public function apply(mixed $value): int
    {
        return $value % $this->divisor;
    }
}
