<?php
/**
 * Class UserService
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\CacheTest\Testing;
use Costalong\Swoft\Cache\Annotation\Mapping\CacheClear;
use Costalong\Swoft\Cache\Annotation\Mapping\CachePut;

/**
 * Class UserService
 *
 */
class UserService
{
    /**
     * 每次都触发写入缓存
     * 当clearListener不为空，调用此事件则清除缓存
     *
     * @CachePut(ttl=3000,key="cache1_#{id}", clearListener="CACHE_CLEAR")
     */
    public function cache2($id)
    {
        return $id;
    }
}
