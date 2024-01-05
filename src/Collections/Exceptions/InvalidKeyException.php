<?php
declare(strict_types=1);

namespace Smpl\Collections\Exceptions;

use OutOfBoundsException;
use Smpl\Collections\Contracts\Identifiable;
use Stringable;

final class InvalidKeyException extends OutOfBoundsException
{
    public static function make(): InvalidKeyException
    {
        return new self('An invalid key was provided, keys must be of type int|string or if an object, implement ' . Identifiable::class . ' or ' . Stringable::class);
    }
}
