<?php
/**
 * Class CacheClearListener
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache;

use Costalong\Swoft\Cache\Register\CacheRegister;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;

/**
 * Class CacheClearListener
 * @Listener(event=Cache::CLEAR_EVENT)
 * @package Costalong\Swoft\Cache
 */
class CacheClearListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        $args = $event->getParams();

        if (!empty($args) && count($args) === 2) {
            $data = CacheRegister::getClearData();
            $data = $data[$args[0]] ?? null;
            if (!empty($data) && is_array($data)) {
                $this->clear($args, $data);
            }
        }
    }

    /**
     * clear cache
     * @param array $args
     * @param array $data
     */
    public function clear(array $args, array $data): void
    {
        $argsMap = $args[1] ?? [];
        $key = $data['data'][0] ?? '';
        $prefix = $key ? '' : $data['className'] . '@' . $data['methodName'];
        $key = CacheRegister::formatedKey($prefix, $argsMap, $key);
        Cache::delete($key);
    }
}
