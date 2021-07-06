<?php
/**
 * Class SetKeyInterface
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Handle\SetKeyListener;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Interface SetKeyInterface
 * @package Costalong\Swoft\Cache\Handle\SetKeyListener
 * @Bean()
 */
interface SetKeyInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function write(array $data);
}
