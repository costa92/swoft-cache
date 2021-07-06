<?php
/**
 * Class SetKeyListener
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Listener;

use Costalong\Swoft\Cache\Handle\SetKeyListener\SetKeyInterface;
use Costalong\Swoft\Cache\Handle\SetKeyListener\SetKeyLogs;
use Swoft\Bean\BeanFactory;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Costalong\Swoft\Cache\Cache;
use Swoft\Redis\RedisDb;

/**
 * Class SetKeyListener
 * @package Costalong\Swoft\Cache\Listener
 * @Listener(event=Cache::SET_KEY_EVENT)
 */
class SetKeyListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        $args = $event->getParams();
        /** @var RedisDb $redisDB */
        $redisDB = $args[2];
        /** @var SetKeyInterface $setKeyClass */
        $setKeyClass = $args[3];
        $data = [
            "key"=> $args[0],
            "value"=> unserialize($args[1]),
            "host"=>$redisDB->getHost(),
            "port"=> $redisDB->getPort(),
            "password" => $redisDB->getPassword(),
            "database" => $redisDB->getDatabase()
        ];

        $this->handleData($data,$setKeyClass);
    }

    /**
     * @param array $data
     * @param  $setKeyClass
     */
    protected function handleData(array $data,$setKeyClass)
    {
        /** @var SetKeyInterface $handle */
        $handle = BeanFactory::getSingleton($setKeyClass);
        if ($handle instanceof SetKeyInterface){
            $handle->write($data);
        }
    }
}
