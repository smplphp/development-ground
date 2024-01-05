<?php

namespace Smpl\Collections\Contracts;

/**
 * Set Contract
 *
 * This contract represents a specific type of {@see \Smpl\Collections\Contracts\Sequence}
 * that does not allow duplicate values.
 *
 * @template V of mixed
 *
 * @extends \Smpl\Collections\Contracts\Sequence<V>
 */
interface Set extends Sequence
{

}
