<?php
/**
 * Class CacheClearParser
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\Cache\Annotation\Parser;

use Costalong\Swoft\Cache\Register\CacheRegister;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Annotation\Exception\AnnotationException;
use Costalong\Swoft\Cache\Annotation\Mapping\CacheClear;
/**
 * Class CacheClearParser
 * @package Costalong\Swoft\Cache\Annotation\Parser
 * @since 2.0
 * @AnnotationParser(CacheClear::class)
 */
class CacheClearParser extends Parser
{

    /**
     * @throws AnnotationException
     */
    public function parse(int $type, $annotationObject): array
    {
        if ($type !== self::TYPE_METHOD) {
            throw new AnnotationException('Annotation CacheClear shoud on method!');
        }
        $key = $annotationObject->getKey();
        $position = $annotationObject->getPosition();
        $data = [
            $key, $position
        ];
        CacheRegister::register($data, $this->className, $this->methodName, 'cacheClear');
        return [];
    }
}
