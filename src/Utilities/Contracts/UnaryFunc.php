<?php

namespace Smpl\Utilities\Contracts;

/**
 * Unary Function
 *
 * This contract represents a specialised {@see \Smpl\Utilities\Contracts\Func}
 * where the argument and return types are the same.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Utilities\Contracts\Func<P, P>
 */
interface UnaryFunc extends Func
{

}
