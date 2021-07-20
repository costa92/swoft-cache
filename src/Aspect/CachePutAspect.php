<?php
/**
 * Class CachePutAspect
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Aspect;

use Costalong\Swoft\Cache\CacheManager;
use Costalong\Swoft\Cache\Register\CacheRegister;
use Psr\SimpleCache\InvalidArgumentException;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Bean\Annotation\Mapping\Inject;
use Costalong\Swoft\Cache\Annotation\Mapping\CachePut;
use Throwable;

/**
 * Class CachePutAspect
 * @package Costalong\Swoft\Cache\Aspect
 * @since 2.0
 *
 * @Aspect(order=1)
 *
 * @PointAnnotation(include={CachePut::class})
 */
class CachePutAspect
{
    /**
     * @Inject()
     * @var CacheManager
     */
    protected $redis;

    /**
     * @Around()
     *
     * @param ProceedingJoinPoint $proceedingJoinPoint
     *
     * @return mixed
     * @throws Throwable|InvalidArgumentException
     */
    public function around(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // Before around
        $className = $proceedingJoinPoint->getClassName();
        $methodName = $proceedingJoinPoint->getMethod();
        $argsMap = $proceedingJoinPoint->getArgsMap();

        $has = CacheRegister::has($className, $methodName, 'cachePut');
        $has && ([$key, $val, $ttl, ] = CacheRegister::get($className, $methodName, 'cachePut'));

        $result = $proceedingJoinPoint->proceed();
        // After around
        if ($has) {
            $data = $result;
            $prefix = $key ? '' : "$className@$methodName";
            $key = CacheRegister::formatedKey($prefix, $argsMap, $key);
            if (!empty($val)) {
                $data = $val;
            }
            $this->redis->set($key, $data, (int)$ttl);
        }
        return $result;
    }
}
