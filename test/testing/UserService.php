<?php
/**
 * Class UserService
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\CacheTest\Testing;
use Costalong\Swoft\Cache\Annotation\Mapping\CacheClear;

/**
 * Class UserService
 *
 */
class UserService
{
    /**
     * 每次都触发清除缓存
     * position标识清除操作的位置，执行前或执行后
     *
     * @CacheClear(position=Cache::ASP_AFTER)
     */
    public function cache3($id)
    {
       var_dump($id);
    }
}
