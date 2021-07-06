<?php
/**
 * Class CacheRememberParser
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Annotation\Parser;

use Costalong\Swoft\Cache\Annotation\Mapping\CacheRemember;
use Costalong\Swoft\Cache\Register\CacheRegister;
use Doctrine\Common\Annotations\AnnotationException;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;

/**
 * Class CacheRememberParser
 * @package Costalong\Swoft\Cache\Annotation\Parser
 * @AnnotationParser(CacheRemember::class)
 * @since 2.0
 */
class CacheRememberParser extends Parser
{
    /**
     * @param int $type
     * @param CacheRemember $annotationObject
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
        $ttl = $annotationObject->getTtl();
        $putListener = $annotationObject->getPutListener();
        $clearListener = $annotationObject->getClearListener();
        $data = [
            $key, $ttl, $putListener, $clearListener
        ];
        CacheRegister::register($data, $this->className, $this->methodName, 'cacheRemember');
        if (!empty($clearListener)) {
            CacheRegister::registerClearData($data, $this->className, $this->methodName);
        }
        return [];
    }
}
