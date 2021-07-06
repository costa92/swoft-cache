<?php
/**
 * Class CacheManager
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache;

use Costalong\Swoft\Cache\Contract\CacheAdapterInterface;
use Costalong\Swoft\Cache\Lock\LockTrait;
use Psr\SimpleCache\CacheInterface;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class CacheManager
 * @package Costalong\Swoft\Cache
 * @Bean("cacheManager")
 */
class CacheManager implements CacheInterface
{
    use LockTrait,CacheAbleTrait;

    /**
     * Current used cache adapter driver
     *
     * @var CacheAdapterInterface
     */
    private $adapter;

    /**
     * @var array
     */
    // private $adapters = [
    //     'file'   => FileAdapter::class,
    //     'coFile' => CoFileAdapter::class,
    //     'array'  => ArrayAdapter::class,
    //     'mTable' => MemTableAdapter::class,
    // ];

    /**
     * Init cache manager
     */
    public function init(): void
    {
        // TODO ...
    }

    /**
     * {@inheritDoc}
     */
    public function has($key): bool
    {
        return $this->adapter->has($key);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null): bool
    {
        return $this->adapter->set($key, $value, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return $this->adapter->get($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key): bool
    {
        return $this->adapter->delete($key);
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear(): bool
    {
        return $this->adapter->clear();
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null): array
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->adapter->getMultiple($keys, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null): bool
    {
        return $this->adapter->setMultiple((array)$values, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMultiple($keys): bool
    {
        return $this->adapter->deleteMultiple((array)$keys);
    }

    /**
     * @return CacheAdapterInterface
     */
    public function getAdapter(): CacheAdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @param CacheAdapterInterface $adapter
     */
    public function setAdapter(CacheAdapterInterface $adapter): void
    {
        $this->adapter = $adapter;
    }
}

