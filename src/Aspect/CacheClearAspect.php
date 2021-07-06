<?php
/**
 * Class CacheClearAspect
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\Cache\Aspect;

use Costalong\Swoft\Cache\Annotation\Mapping\CacheClear;
use Costalong\Swoft\Cache\CacheManager;
use Costalong\Swoft\Cache\Register\CacheRegister;
use Psr\SimpleCache\InvalidArgumentException;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Bean\Annotation\Mapping\Inject;
use Throwable;
use Costalong\Swoft\Cache\Cache as CacheStatic;

/**
 * Class CacheClearAspect
 * @package Costalong\Swoft\Cache\Aspect
 * @since 2.0
 *
 * @Aspect(order=1)
 * @PointAnnotation(include={CacheClear::class})
 */
class CacheClearAspect
{
    /**
     * @Inject()
     * @var CacheManager
     */
    private $redis;

    /**
     * @Around()
     *
     * @param ProceedingJoinPoint $proceedingJoinPoint
     *
     * @return mixed
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function around(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // Before around
        $className = $proceedingJoinPoint->getClassName();
        $methodName = $proceedingJoinPoint->getMethod();
        $argsMap = $proceedingJoinPoint->getArgsMap();

        $has = CacheRegister::has($className, $methodName, 'cacheClear');

        $key = "";
        $position  = "";
        if ($has) {
            [$key, $position] = CacheRegister::get($className, $methodName, 'cacheClear');
            $prefix = $key ? '' : "$className@$methodName";
            $key = CacheRegister::formatedKey($prefix, $argsMap, $key);
        }

        if ($has && $position === CacheStatic::ASP_BEFORE) {
            $this->redis->delete($key);
        }
        $result = $proceedingJoinPoint->proceed();
        // After around
        if ($has && $position === CacheStatic::ASP_AFTER) {
            $this->redis->delete($key);
        }
        return $result;
    }

}
