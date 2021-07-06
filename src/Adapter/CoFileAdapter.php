<?php declare(strict_types=1);

namespace Costalong\Swoft\Cache\Adapter;

use Costalong\Swoft\Cache\Concern\CoFileSystemTrait;

/**
 * Class CoFileAdapter
 *
 * @since 2.0.8
 */
class CoFileAdapter extends FileAdapter
{
    use CoFileSystemTrait;
}
