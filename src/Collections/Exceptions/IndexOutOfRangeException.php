<?php
declare(strict_types=1);

namespace Smpl\Collections\Exceptions;

use OutOfRangeException;

final class IndexOutOfRangeException extends OutOfRangeException
{
    /**
     * @param int  $index
     * @param int  $min
     * @param int  $max
     * @param bool $inclusive
     *
     * @return self
     */
    public static function index(int $index, int $min, int $max, bool $inclusive = true): IndexOutOfRangeException
    {
        return new self ('Index ' . $index . ' it outside the range of <' . $min . ', ' . ($inclusive ? $max : $max - 1) . '>');
    }

    public static function count(int $requested, int $total): IndexOutOfRangeException
    {
        return new self('Provided count ' . $requested . ' is greater than ' . $total . ' and would result in an index range that is outside of this collections acceptable range');
    }
}
