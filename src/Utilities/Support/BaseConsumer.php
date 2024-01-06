<?php
declare(strict_types=1);

namespace Smpl\Utilities\Support;

use Smpl\Utilities\Contracts\Consumer;

/**
 * Base Consumer
 *
 * This is a base class that can be used by all {@see \Smpl\Utilities\Contracts\Consumer}
 * implementations to provide the base functionality, such as the
 * {@see \Smpl\Utilities\Contracts\Func} compatibility.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Utilities\Support\BaseFunc<P, void>
 * @implements \Smpl\Utilities\Contracts\Consumer<P>
 */
abstract class BaseConsumer extends BaseFunc implements Consumer
{

}
