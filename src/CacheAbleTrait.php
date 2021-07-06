<?php
/**
 * Class CacheAbleTrait
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache;

use Closure;
use Costalong\Swoft\Cache\Lock\LockContract;
use Exception;
use Swoft\Bean\BeanFactory;
use Swoft\Event\EventInterface;

trait CacheAbleTrait
{
    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     * @param $key
     * @param $ttl
     * @param Closure $callback
     * @return mixed
     */
    public function remember($key, $ttl, Closure $callback)
    {
        $value = $this->get($key);

        if ($value !== null) {
            return $value;
        }
        $this->set($key, $value = $callback(), $ttl);

        return $value;
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function forever(string $key, $value): bool
    {
        return $this->set($key, $value, -1);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param string $key
     * @param Closure $callback
     * @return mixed
     */
    public function rememberForever(string $key, Closure $callback)
    {
        $value = $this->get($key);

        if ($value !== null) {
            return $value;
        }
        $this->forever($key, $value = $callback());

        return $value;
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function pull(string $key, $default = null)
    {
        return tap($this->get($key, $default), function () use ($key) {
            $this->delete($key);
        });
    }

    /**
     * Get a lock instance.
     *
     * @param  $key
     * @param int $ttl
     * @param string $value
     * @return LockContract
     * @throws Exception
     */
    public function lock($key, int $ttl = 0, string $value = ''): LockContract
    {
        /** @var LockContract $lock */
        $lock = BeanFactory::getBean(Cache::LOCK);
        $lock->reset($key, $ttl, $value);
        return $lock;
    }

    /**
     * 缓存清除事件
     * @param string $event
     * @param array $args
     * @param null $target
     * @return EventInterface
     */
    public function clearTrigger(string $event, array $args = [], $target = null): EventInterface
    {
        return \Swoft::trigger(Cache::CLEAR_EVENT, $target, $event, $args);
    }
}
