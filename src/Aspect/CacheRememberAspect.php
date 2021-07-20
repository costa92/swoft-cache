<?php
/**
 * Class CacheRememberAspect
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Aspect;

use Costalong\Swoft\Cache\CacheManager;
use Costalong\Swoft\Cache\Register\CacheRegister;
use Swoft;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Costalong\Swoft\Cache\Annotation\Mapping\CacheRemember;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Bean\Annotation\Mapping\Inject;
use Throwable;

/**
 * Class CacheRememberAspect
 * @package Costalong\Swoft\Cache\Aspect
 * @since 2.0
 * @Aspect(order=1)
 * @PointAnnotation(include={CacheRemember::class})
 */
class CacheRememberAspect
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
     * @throws Throwable
     */
    public function around(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // Before around
        $className = $proceedingJoinPoint->getClassName();
        $methodName = $proceedingJoinPoint->getMethod();
        $argsMap = $proceedingJoinPoint->getArgsMap();

        $has = CacheRegister::has($className, $methodName, 'cacheRemember');

        if (!$has) {
            return $proceedingJoinPoint->proceed();
        }

        [$key, $ttl, $putListener,] = CacheRegister::get($className, $methodName, 'cacheRemember');

        $prefix = $key ? '' : "$className@$methodName";
        $key = CacheRegister::formatedKey($prefix, $argsMap, $key);

        return $this->redis->remember(
            $key,
            (int)$ttl,
            static function () use ($proceedingJoinPoint, $putListener, $key, $ttl) {
                $result = $proceedingJoinPoint->proceed();
                if (!empty($putListener)) {
                    Swoft::trigger($putListener, $key, $result, $ttl);
                }
                return $result;
            }
        );
    }
}
