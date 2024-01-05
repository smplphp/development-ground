<?php

namespace Smpl\Functional\Contracts;

/**
 * Unary Function
 *
 * This contract represents a specialised {@see \Smpl\Functional\Contracts\Func}
 * where the argument and return types are the same.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Contracts\Func<P, P>
 */
interface UnaryFunc extends Func
{

}
