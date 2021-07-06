<?php
/**
 * Class SetKeyLogs
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\Cache\Handle\SetKeyListener;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Log\Helper\CLog;

/**
 * Class SetKeyLogs
 * @package Costalong\Swoft\Cache\Handle\SetKeyListener
 * @Bean()
 */
class SetKeyLogs implements SetKeyInterface
{
    /**
     * @param array $data
     * @return void
     */
    public function write(array $data)
    {
        CLog::info("写入缓存数据的信息".json_encode($data));
    }
}
