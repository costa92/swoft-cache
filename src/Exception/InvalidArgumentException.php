<?php
/**
 * Class InvalidArgumentException
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Exception;


use RuntimeException;

/**
 * Class InvalidArgumentException
 * @package Costalong\Swoft\Cache\Exception
 */
class InvalidArgumentException extends RuntimeException implements \Psr\SimpleCache\InvalidArgumentException
{

}
