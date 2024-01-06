<?php
declare(strict_types=1);

namespace Smpl\Utilities\Functions;

use Override;
use Smpl\Utilities\Support\BaseFunc;

/**
 * Modulo Function
 *
 * Represents an implementation of {@see \Smpl\Utilities\Contracts\Func} that performs
 * a modulo operation using the % operator.
 *
 * @extends \Smpl\Utilities\Support\BaseFunc<int, int>
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
