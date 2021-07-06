<?php declare(strict_types=1);

namespace Costalong\Swoft\Cache;

use Costalong\Swoft\Cache\Adapter\MultiFileAdapter;
use Costalong\Swoft\Cache\Adapter\RedisAdapter;
use Costalong\Swoft\Cache\Lock\RedisLock;
use Swoft\Helper\ComposerJSON;
use Swoft\Serialize\PhpSerializer;
use Swoft\SwoftComponent;
use function dirname;

/**
 * Class AutoLoader
 */
class AutoLoader extends SwoftComponent
{
    /**
     * Get namespace and dir
     *
     * @return array
     * [
     *     namespace => dir path
     * ]
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * Metadata information for the component.
     *
     * @return array
     * @see ComponentInterface::getMetadata()
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }

    /**
     * @return array
     */
    public function beans(): array
    {
        return [
            Cache::MANAGER    => [
                'class'   => CacheManager::class,
                'adapter' => bean(Cache::ADAPTER),
            ],
            Cache::ADAPTER    => [
                'class'      => RedisAdapter::class,
                'serializer' => bean(Cache::SERIALIZER),
                'redis' => bean('redis.pool'),
            ],
            //cache原子锁配置
            Cache::LOCK => [
                'class' => RedisLock::class,
                'redis' => bean('redis.pool'),
                'prefix' => 'lock:'
            ],
            Cache::SERIALIZER => [
                'class' => PhpSerializer::class
            ]
        ];
    }
}
