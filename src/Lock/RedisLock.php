<?php
/**
 * Class RedisLock
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Lock;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Redis\Pool;

/**
 * Class RedisLock
 * @package Costalong\Swoft\Cache\Lock
 * @Bean("cacheLock", scope=Bean::PROTOTYPE)
 *
 */
class RedisLock extends Lock
{
    /**
     * The Redis factory implementation.
     * @var Pool
     */
    protected $redis;
    /**
     * @var string
     */
    protected $prefix = 'lock:';

    /**
     * Attempt to acquire the lock.
     *
     * @return bool
     */
    public function acquire(): bool
    {
        $result = $this->redis->setnx($this->name, $this->owner);

        if ($result && $this->seconds > 0) {
            $this->redis->expire($this->name, $this->seconds);
        }

        return $result;
    }

    /**
     * Release the lock.
     *
     * @return bool
     */
    public function release(): bool
    {
        return (bool)$this->redis->eval($this->releaseLockScript(), [$this->name, $this->owner], 1);
    }

    /**
     * Releases this lock in disregard of ownership.
     *
     * @return void
     */
    public function forceRelease(): void
    {
        $this->redis->del($this->name);
    }

    /**
     * Returns the owner value written into the driver for this lock.
     *
     * @return string
     */
    protected function getCurrentOwner(): string
    {
        return $this->redis->get($this->name);
    }

    /**
     * Get the Lua script to atomically release a lock.
     *
     * KEYS[1] - The name of the lock
     * ARGV[1] - The owner key of the lock instance trying to release it
     *
     * @return string
     */
    private function releaseLockScript(): string
    {
        return <<<'LUA'
if redis.call("get",KEYS[1]) == ARGV[1] then
    return redis.call("del",KEYS[1])
else
    return 0
end
LUA;
    }
}
