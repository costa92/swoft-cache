<?php
/**
 * Class CachePutParser
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Annotation\Parser;


use Costalong\Swoft\Cache\Annotation\Mapping\CachePut;
use Costalong\Swoft\Cache\Register\CacheRegister;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Annotation\Exception\AnnotationException;

/**
 * Class CachePutParser
 * @package Costalong\Swoft\Cache\Annotation\Parser
 * @AnnotationParser(CachePut::class)
 * @since 2.0
 */
class CachePutParser extends Parser
{
    /**
     * @param int $type
     * @param CachePut $annotationObject
     *
     * @return array
     * @throws AnnotationException
     */
    public function parse(int $type, $annotationObject): array
    {
        if ($type !== self::TYPE_METHOD) {
            throw new AnnotationException('Annotation CacheClear shoud on method!');
        }
        $key = $annotationObject->getKey();
        $val = $annotationObject->getVal();
        $ttl = $annotationObject->getTtl();
        $clearListener = $annotationObject->getClearListener();
        $data = [
            $key, $val, $ttl, $clearListener
        ];
        CacheRegister::register($data, $this->className, $this->methodName, 'cachePut');
        if (!empty($clearListener)) {
            CacheRegister::registerClearData($data, $this->className, $this->methodName);
        }
        return [];
    }
}
