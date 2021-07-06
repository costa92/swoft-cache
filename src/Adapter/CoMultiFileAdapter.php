<?php declare(strict_types=1);

namespace Costalong\Swoft\Cache\Adapter;


use Costalong\Swoft\Cache\Concern\CoFileSystemTrait;


/**
 * Class CoMultiFileAdapter
 *
 * @since 2.0.7
 */
class CoMultiFileAdapter extends MultiFileAdapter
{
    use CoFileSystemTrait;
}
