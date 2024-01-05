<?php
declare(strict_types=1);

namespace Smpl\Collections\Exceptions;

use LogicException;

final class UnsupportedOperationException extends LogicException
{
    public static function immutable(string $class, string $method): UnsupportedOperationException
    {
        return new self('The method \'' . $class . '::' . $method . '\' is a mutable method and cannot be called on an immutable class');
    }
}
