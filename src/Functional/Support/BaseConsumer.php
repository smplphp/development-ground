<?php
declare(strict_types=1);

namespace Smpl\Functional\Support;

use Smpl\Functional\Contracts\Consumer;

/**
 * Base Consumer
 *
 * This is a base class that can be used by all {@see \Smpl\Functional\Contracts\Consumer}
 * implementations to provide the base functionality, such as the
 * {@see \Smpl\Functional\Contracts\Func} compatibility.
 *
 * @template P of mixed
 *
 * @extends \Smpl\Functional\Support\BaseFunc<P, void>
 * @implements \Smpl\Functional\Contracts\Consumer<P>
 */
abstract class BaseConsumer extends BaseFunc implements Consumer
{

}
