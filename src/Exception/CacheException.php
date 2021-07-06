<?php
/**
 * Class CacheException
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\Cache\Exception;

use RuntimeException;

/**
 * Class CacheException
 * @package Costalong\Swoft\Cache\Exception
 * @since 2.0.7
 */
class CacheException extends RuntimeException implements \Psr\SimpleCache\CacheException
{

}
